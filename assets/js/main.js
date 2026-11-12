document.addEventListener('DOMContentLoaded', function () {
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

  document.querySelectorAll('[data-confirm]').forEach(function (link) {
    link.addEventListener('click', function (event) {
      if (!window.confirm(link.getAttribute('data-confirm'))) {
        event.preventDefault();
      }
    });
  });

  // Pesquisa por texto livre + Filtro por categoria
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
