</main>
    <footer class="site-footer">
        <div class="container">
            <p>© 2026 - Projeto Programação Web (IPVC - ESTG)</p>
        </div>
    </footer>

    <!-- Modal de Confirmação Personalizado -->
    <div id="confirm-modal" class="modal-backdrop" role="dialog" aria-modal="true" aria-labelledby="confirm-modal-title" hidden>
        <div class="modal-box">
            <div class="modal-icon-danger" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                    <line x1="10" x2="10" y1="11" y2="17"/>
                    <line x1="14" x2="14" y1="11" y2="17"/>
                </svg>
            </div>
            <h2 id="confirm-modal-title">Eliminar veículo</h2>
            <p id="confirm-modal-message">Tens a certeza de que pretendes eliminar este veículo?</p>
            <div class="modal-actions">
                <button type="button" id="confirm-modal-cancel" class="button-secondary">Cancelar</button>
                <a id="confirm-modal-accept" href="#" class="button-danger">Sim, eliminar</a>
            </div>
        </div>
    </div>

    <script src="<?php echo $url_alias; ?>/assets/js/main.js"></script>
</body>
</html>