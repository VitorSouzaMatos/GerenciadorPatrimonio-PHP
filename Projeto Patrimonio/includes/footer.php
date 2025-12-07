<?php
// includes/footer.php
?>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Confirmar exclusões
        document.querySelectorAll('.btn-excluir').forEach(btn => {
            btn.addEventListener('click', function(e) {
                if (!confirm('Tem certeza que deseja excluir este registro?')) {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>
</html>