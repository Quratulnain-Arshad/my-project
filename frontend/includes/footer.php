<style>
.site-footer{background:#043915;color:#fff;text-align:center;padding:28px 20px;margin-top:40px}
.site-footer .footer-brand{display:flex;align-items:center;justify-content:center;gap:8px;font-size:1.2rem;font-weight:700;margin-bottom:8px}
.site-footer .footer-tagline{font-size:.85rem;color:#a5d6a7;margin-bottom:14px}
.site-footer .footer-nav{display:flex;justify-content:center;gap:20px;flex-wrap:wrap;margin-bottom:14px}
.site-footer .footer-nav a{color:#4CAF50;text-decoration:none;font-size:.9rem}
.site-footer .footer-nav a:hover{text-decoration:underline}
.site-footer .footer-copy{font-size:.75rem;color:#81c784}

/* Image Preview Modal */
.img-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.88);z-index:9999;align-items:center;justify-content:center;cursor:pointer}
.img-modal.open{display:flex}
.img-modal img{max-width:92%;max-height:85vh;border-radius:10px;object-fit:contain;cursor:default;box-shadow:0 4px 32px rgba(0,0,0,.5)}
.img-modal .modal-close{position:absolute;top:14px;right:18px;font-size:2.4rem;color:#fff;background:none;border:none;cursor:pointer;line-height:1;padding:4px 10px;opacity:.8;font-family:sans-serif}
.img-modal .modal-close:hover{opacity:1}
</style>

<footer class="site-footer">
    <div class="footer-brand">
        <img src="assets/about-bottom-img.png" alt="FarmEase" width="30" height="30" style="object-fit:contain">
        FarmEase
    </div>
    <p class="footer-tagline" id="footer-tagline">Empowering farmers with smart, accessible knowledge.</p>
    <nav class="footer-nav">
        <a href="index.php"><span id="footer-nav-home">Home</span></a>
        <a href="crop-info.php"><span id="footer-nav-crop-info">Crop Info</span></a>
        <a href="agri-cost.php"><span id="footer-nav-agri-cost">AgriCost</span></a>
        <a href="contact.php"><span id="footer-nav-contact">Contact</span></a>
    </nav>
    <p class="footer-copy" id="footer-copy">&copy; <?= date('Y') ?> FarmEase. All rights reserved.</p>
    <p style="margin-top:10px">
        <a href="../backend/login.php" style="font-size:.72rem;color:#4caf5066;text-decoration:none;transition:color .2s"
           onmouseover="this.style.color='#4caf50'" onmouseout="this.style.color='#4caf5066'">
            Admin Login
        </a>
    </p>
</footer>

<!-- Shared image preview modal (used by crop guide pages) -->
<div id="imgModal" class="img-modal" onclick="document.getElementById('imgModal').classList.remove('open')">
    <button class="modal-close" onclick="event.stopPropagation();document.getElementById('imgModal').classList.remove('open')">&times;</button>
    <img id="modalImg" src="" alt="preview" onclick="event.stopPropagation()">
</div>
<script src="js/lang-shared.js"></script>
<script>
function openImgModal(src) {
    document.getElementById('modalImg').src = src;
    document.getElementById('imgModal').classList.add('open');
}
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') document.getElementById('imgModal').classList.remove('open');
});
</script>
