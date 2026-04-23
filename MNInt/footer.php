<!-- Footer -->
 <link rel="stylesheet" href="css/footer.css">
    
 
// footer.php - Contains the footer section
?>
<!-- Footer Start -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>MN International</h3>
                <p>Premium Security Solutions</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Support</h4>
                <ul>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="privacy-policy.php">Privacy Policy</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                    <li><a href="returns.php">Return Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>Contact Info</h4>
                <ul>
                    <footer class="footer">
        
          
                    <li><i class="fas fa-map-marker-alt"></i> Kathmandu, Nepal</li>
                    <li><i class="fas fa-map-marker-alt"></i> https://www.instagram.com/</li>
           <li><i class="fas fa-map-marker-alt"></i> https://twitter.com/</li>
             <li><i class="fas fa-map-marker-alt"></i> https://www.facebook.com/</li>
                    <li><i class="fas fa-phone"></i> +977 9800000000</li>
                    <li><i class="fas fa-envelope"></i> info@mninternational.com</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> MNInternational. All Rights Reserved.</p>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript for category filtering -->
<script>
function filterProducts(categoryId) {
    // Hide all category sections
    const allSections = document.querySelectorAll('.category-section');
    allSections.forEach(section => {
        section.classList.remove('active');
    });
    
    // Show selected category section
    if (categoryId === 'all') {
        const allProductsSection = document.getElementById('all-products');
        if (allProductsSection) {
            allProductsSection.classList.add('active');
        }
    } else {
        const targetSection = document.getElementById(`category-${categoryId}`);
        if (targetSection) {
            targetSection.classList.add('active');
        }
    }
    
    // Update active tab styling
    const allTabs = document.querySelectorAll('.tab-btn');
    allTabs.forEach(tab => {
        tab.classList.remove('active');
    });
    
    // Add active class to clicked tab
    if (event && event.target) {
        event.target.classList.add('active');
    }
    
    // Smooth scroll to products section
    const productsSection = document.querySelector('.products-banner');
    if (productsSection) {
        productsSection.scrollIntoView({ behavior: 'smooth' });
    }
}

// Initialize - show all products by default
document.addEventListener('DOMContentLoaded', function() {
    filterProducts('all');
});
</script>
</body>
</html>