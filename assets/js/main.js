document.addEventListener('DOMContentLoaded', function () {
  // 1. Menu Mobile
  var menuToggle = document.querySelector('.menu-toggle');
  var navigation = document.querySelector('#primary-navigation');

  if (menuToggle && navigation) {
    menuToggle.addEventListener('click', function () {
      var isOpen = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', String(!isOpen));
      menuToggle.setAttribute('aria-label', isOpen ? 'Abrir menu' : 'Fechar menu');
      navigation.classList.toggle('is-open', !isOpen);
    });

    navigation.addEventListener('click', function (event) {
      if (event.target.closest('a')) {
        menuToggle.setAttribute('aria-expanded', 'false');
        menuToggle.setAttribute('aria-label', 'Abrir menu');
        navigation.classList.remove('is-open');
      }
    });
  }

  // 2. Modo Escuro (Dark Mode) com persistência em localStorage
  var themeToggle = document.querySelector('#theme-toggle');
  if (themeToggle) {
    themeToggle.addEventListener('click', function () {
      var isDark = document.documentElement.getAttribute('data-theme') === 'dark';
      if (isDark) {
        document.documentElement.removeAttribute('data-theme');
        localStorage.setItem('theme', 'light');
      } else {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
      }
    });
  }

  // 3. Modal de Confirmação Personalizado para Eliminar
  var confirmModal = document.querySelector('#confirm-modal');
  var modalMessage = document.querySelector('#confirm-modal-message');
  var modalAccept = document.querySelector('#confirm-modal-accept');
  var modalCancel = document.querySelector('#confirm-modal-cancel');

  function closeConfirmModal() {
    if (confirmModal) {
      confirmModal.hidden = true;
    }
  }

  if (confirmModal && modalMessage && modalAccept && modalCancel) {
    document.querySelectorAll('[data-confirm]').forEach(function (link) {
      link.addEventListener('click', function (event) {
        event.preventDefault();
        var card = link.closest('.vehicle-card');
        var brandTitle = card ? card.querySelector('h2') : null;
        var vehicleName = brandTitle ? brandTitle.textContent.trim() : '';

        modalMessage.textContent = vehicleName
          ? 'Tens a certeza de que pretendes eliminar o veículo "' + vehicleName + '"? Esta ação não pode ser desfeita.'
          : link.getAttribute('data-confirm');

        modalAccept.setAttribute('href', link.getAttribute('href'));
        confirmModal.hidden = false;
        modalCancel.focus();
      });
    });

    modalCancel.addEventListener('click', closeConfirmModal);
    confirmModal.addEventListener('click', function (event) {
      if (event.target === confirmModal) {
        closeConfirmModal();
      }
    });
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape' && !confirmModal.hidden) {
        closeConfirmModal();
      }
    });
  }

  // 4. Alertas / Toasts que fecham manualmente ou desaparecem ao fim de 4.5s
  document.querySelectorAll('.notice').forEach(function (notice) {
    var closeBtn = document.createElement('button');
    closeBtn.type = 'button';
    closeBtn.className = 'notice-close';
    closeBtn.setAttribute('aria-label', 'Fechar notificação');
    closeBtn.innerHTML = '×';
    notice.appendChild(closeBtn);

    function dismissNotice() {
      notice.classList.add('is-hiding');
      setTimeout(function () {
        notice.remove();
      }, 300);
    }

    closeBtn.addEventListener('click', dismissNotice);
    setTimeout(dismissNotice, 4500);
  });

  // 5. Validação Visual nos Formulários (Create e Update)
  var currentYear = new Date().getFullYear();
  document.querySelectorAll('form').forEach(function (form) {
    var anoInput = form.querySelector('input[name="ano_fundacao"]');
    if (anoInput) {
      anoInput.setAttribute('min', '1700');
      anoInput.setAttribute('max', String(currentYear));
    }

    function validateField(field) {
      var wrapper = field.parentElement;
      var errorEl = wrapper.querySelector('.field-error');
      if (!errorEl) {
        errorEl = document.createElement('span');
        errorEl.className = 'field-error';
        wrapper.appendChild(errorEl);
      }

      var value = field.value.trim();
      var message = '';

      if (field.hasAttribute('required') && !value) {
        message = 'Este campo é obrigatório.';
      } else if (field.name === 'ano_fundacao' && value) {
        var yearVal = Number(value);
        if (isNaN(yearVal) || yearVal < 1700 || yearVal > currentYear) {
          message = 'Introduz um ano válido entre 1700 e ' + currentYear + '.';
        }
      } else if ((field.name === 'marca' || field.name === 'pais_origem') && value.length < 2) {
        message = 'Deve conter pelo menos 2 caracteres.';
      }

      if (message) {
        field.classList.add('is-invalid');
        field.classList.remove('is-valid');
        errorEl.textContent = message;
        return false;
      } else {
        field.classList.remove('is-invalid');
        if (value) {
          field.classList.add('is-valid');
        }
        errorEl.textContent = '';
        return true;
      }
    }

    var fields = form.querySelectorAll('input, select');
    fields.forEach(function (field) {
      field.addEventListener('blur', function () {
        validateField(field);
      });
      field.addEventListener('input', function () {
        if (field.classList.contains('is-invalid')) {
          validateField(field);
        }
      });
    });

    form.addEventListener('submit', function (event) {
      var allValid = true;
      fields.forEach(function (field) {
        if (!validateField(field)) {
          allValid = false;
        }
      });
      if (!allValid) {
        event.preventDefault();
        var firstInvalid = form.querySelector('.is-invalid');
        if (firstInvalid) {
          firstInvalid.focus();
        }
      }
    });
  });

  // 6. Pesquisa por texto livre + Filtro por categoria
  var searchInput = document.querySelector('#search-veiculos');
  var categorySelect = document.querySelector('#filter-categoria');
  var clearBtn = document.querySelector('#clear-filters');
  var resetEmptyBtn = document.querySelector('#reset-empty-filters');
  var vehicleGrid = document.querySelector('#vehicle-grid');
  var noResultsMsg = document.querySelector('#no-results-message');
  var resultsCounter = document.querySelector('#results-counter');

  if (searchInput && categorySelect && vehicleGrid) {
    var cards = Array.from(vehicleGrid.querySelectorAll('.vehicle-card'));

    function normalizeText(text) {
      return (text || '')
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .trim();
    }

    function filterVehicles() {
      var query = normalizeText(searchInput.value);
      var selectedCategory = normalizeText(categorySelect.value);
      var visibleCount = 0;

      cards.forEach(function (card) {
        var cardSearch = normalizeText(card.getAttribute('data-search'));
        var cardCategory = normalizeText(card.getAttribute('data-categoria'));

        var matchesSearch = !query || cardSearch.indexOf(query) !== -1;
        var matchesCategory = !selectedCategory || cardCategory === selectedCategory;

        if (matchesSearch && matchesCategory) {
          card.hidden = false;
          visibleCount++;
        } else {
          card.hidden = true;
        }
      });

      var hasActiveFilters = Boolean(query || selectedCategory);
      if (clearBtn) {
        clearBtn.hidden = !hasActiveFilters;
      }

      if (resultsCounter) {
        resultsCounter.textContent = 'A mostrar ' + visibleCount + ' veículo(s)';
      }

      if (noResultsMsg) {
        noResultsMsg.hidden = visibleCount > 0;
      }

      vehicleGrid.hidden = visibleCount === 0;
    }

    function resetFilters() {
      searchInput.value = '';
      categorySelect.value = '';
      filterVehicles();
      searchInput.focus();
    }

    searchInput.addEventListener('input', filterVehicles);
    categorySelect.addEventListener('change', filterVehicles);

    if (clearBtn) {
      clearBtn.addEventListener('click', resetFilters);
    }
    if (resetEmptyBtn) {
      resetEmptyBtn.addEventListener('click', resetFilters);
    }
  }
});