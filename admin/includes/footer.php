    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.sidebar');
    const main = document.querySelector('.main');
    if (sidebar && main) {
        const syncHeight = () => {
            main.style.minHeight = Math.max(
                document.querySelector('.content')?.scrollHeight + 80 || 0,
                window.innerHeight - 64
            ) + 'px';
        };
        syncHeight();
        window.addEventListener('resize', syncHeight);
    }
});
</script>
</body>
</html>
