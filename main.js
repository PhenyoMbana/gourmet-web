// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
    const mainNav = document.querySelector('.main-nav');
    
    if (mobileMenuToggle && mainNav) {
        mobileMenuToggle.addEventListener('click', function() {
            mainNav.classList.toggle('active');
            this.classList.toggle('active');
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.main-nav') && !event.target.closest('.mobile-menu-toggle')) {
            mainNav.classList.remove('active');
            mobileMenuToggle.classList.remove('active');
        }
    });

    // Form Validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!validateForm(this)) {
                event.preventDefault();
            }
        });
    });

    // Quantity Controls
    const quantityControls = document.querySelectorAll('.quantity-controls');
    quantityControls.forEach(control => {
        const minusBtn = control.querySelector('.minus');
        const plusBtn = control.querySelector('.plus');
        const input = control.querySelector('input[type="number"]');

        if (minusBtn && plusBtn && input) {
            minusBtn.addEventListener('click', () => {
                if (input.value > 1) {
                    input.value = parseInt(input.value) - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });

            plusBtn.addEventListener('click', () => {
                input.value = parseInt(input.value) + 1;
                input.dispatchEvent(new Event('change'));
            });
        }
    });

    // Add to Cart Animation
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productCard = this.closest('.product-card');
            if (productCard) {
                const productImage = productCard.querySelector('.product-image img');
                if (productImage) {
                    animateAddToCart(productImage);
                }
            }
        });
    });

    // Search Functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length < 2) {
                return;
            }
            
            searchTimeout = setTimeout(() => {
                showLoadingSpinner();
                searchProducts(query);
            }, 300);
        });
    }
});

// Form Validation Function
function validateForm(form) {
    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');
    
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            showError(field, 'This field is required');
            isValid = false;
        } else {
            clearError(field);
        }

        // Email validation
        if (field.type === 'email' && field.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(field.value)) {
                showError(field, 'Please enter a valid email address');
                isValid = false;
            }
        }

        // Phone validation
        if (field.name === 'phone' && field.value) {
            const phoneRegex = /^[0-9+\-\s()]{10,}$/;
            if (!phoneRegex.test(field.value)) {
                showError(field, 'Please enter a valid phone number');
                isValid = false;
            }
        }
    });

    return isValid;
}

// Show Error Message
function showError(field, message) {
    const errorDiv = field.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains('error-message')) {
        errorDiv.textContent = message;
    } else {
        const newErrorDiv = document.createElement('div');
        newErrorDiv.className = 'error-message';
        newErrorDiv.textContent = message;
        field.parentNode.insertBefore(newErrorDiv, field.nextSibling);
    }
    field.classList.add('error');
}

// Clear Error Message
function clearError(field) {
    const errorDiv = field.nextElementSibling;
    if (errorDiv && errorDiv.classList.contains('error-message')) {
        errorDiv.remove();
    }
    field.classList.remove('error');
}

// Add to Cart Animation
function animateAddToCart(productImage) {
    const cartIcon = document.querySelector('.cart-icon');
    if (!cartIcon) return;

    const imageClone = productImage.cloneNode();
    const imageRect = productImage.getBoundingClientRect();
    const cartRect = cartIcon.getBoundingClientRect();

    imageClone.style.cssText = `
        position: fixed;
        top: ${imageRect.top}px;
        left: ${imageRect.left}px;
        width: ${imageRect.width}px;
        height: ${imageRect.height}px;
        z-index: 1000;
        transition: all 0.8s ease-in-out;
        border-radius: 50%;
        object-fit: cover;
    `;

    document.body.appendChild(imageClone);

    requestAnimationFrame(() => {
        imageClone.style.top = `${cartRect.top}px`;
        imageClone.style.left = `${cartRect.left}px`;
        imageClone.style.width = '20px';
        imageClone.style.height = '20px';
        imageClone.style.opacity = '0';
    });

    setTimeout(() => {
        imageClone.remove();
        updateCartCount();
    }, 800);
}

// Update Cart Count
function updateCartCount() {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        const currentCount = parseInt(cartCount.textContent) || 0;
        cartCount.textContent = currentCount + 1;
        cartCount.style.animation = 'bump 0.3s ease-in-out';
        setTimeout(() => {
            cartCount.style.animation = '';
        }, 300);
    }
}

// Search Functionality
async function searchProducts(query) {
    try {
        const response = await fetch(`search.php?q=${encodeURIComponent(query)}`);
        const data = await response.json();
        
        if (data.success) {
            displaySearchResults(data.results);
        } else {
            showNotification(data.message, 'error');
        }
    } catch (error) {
        showNotification('Error searching products', 'error');
    } finally {
        hideLoadingSpinner();
    }
}

function displaySearchResults(results) {
    const productGrid = document.querySelector('.product-grid');
    if (!productGrid) return;
    
    if (results.length === 0) {
        productGrid.innerHTML = '<p class="no-results">No products found</p>';
        return;
    }
    
    const html = results.map(product => `
        <div class="product-card">
            <div class="product-image">
                <img src="${product.image}" alt="${product.name}">
            </div>
            <div class="product-content">
                <h3>${product.name}</h3>
                <p>${product.description}</p>
                <div class="product-price">${format_price(product.price)}</div>
                <button class="btn btn-primary add-to-cart" data-product-id="${product.id}">
                    Add to Cart
                </button>
            </div>
        </div>
    `).join('');
    
    productGrid.innerHTML = html;
    
    // Reattach event listeners to new add to cart buttons
    attachAddToCartListeners();
}

// Notification System
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Loading Spinner
function showLoadingSpinner() {
    const spinner = document.createElement('div');
    spinner.className = 'loading-spinner';
    spinner.id = 'global-spinner';
    document.body.appendChild(spinner);
}

function hideLoadingSpinner() {
    const spinner = document.getElementById('global-spinner');
    if (spinner) {
        spinner.remove();
    }
}

// Form Submission Handling
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', async function(e) {
        if (!validateForm(this)) {
            e.preventDefault();
            return;
        }
        
        const submitButton = this.querySelector('[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
            submitButton.innerHTML = '<div class="loading-spinner"></div>';
        }
        
        try {
            const formData = new FormData(this);
            const response = await fetch(this.action, {
                method: this.method,
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message || 'Operation successful');
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            } else {
                showNotification(data.message || 'Operation failed', 'error');
            }
        } catch (error) {
            showNotification('An error occurred', 'error');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.innerHTML = submitButton.dataset.originalText || 'Submit';
            }
        }
    });
});

// Helper function to format price
function format_price(price) {
    return 'R' + parseFloat(price).toFixed(2);
}

// Attach add to cart listeners
function attachAddToCartListeners() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', async function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            const productCard = this.closest('.product-card');
            
            if (productCard) {
                const productImage = productCard.querySelector('.product-image img');
                if (productImage) {
                    animateAddToCart(productImage);
                }
            }
            
            try {
                const response = await fetch('add_to_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    showNotification('Product added to cart');
                    updateCartCount();
                } else {
                    showNotification(data.message || 'Failed to add product to cart', 'error');
                }
            } catch (error) {
                showNotification('Error adding product to cart', 'error');
            }
        });
    });
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    attachAddToCartListeners();
    
    // Display any notifications from PHP
    const notifications = document.querySelectorAll('.notification');
    notifications.forEach(notification => {
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    });
}); 