<?php include 'header.php'; ?>

<link rel="stylesheet" href="./assets/css/contact.css">

<section class="contact-top-section section-padding">
    <div class="container text-center">
        <!-- <p class="top-subtitle">GET IN TOUCH</p> -->
        <h2 class="section-title">Get in <span>Touch</span></h2>
        <p class="section-subtitle">Fill out the form below and we'll get back to you as soon as possible.</p>

        <div class="contact-grid-4">
            <div class="info-box">
                <div class="icon-circle"><i class="fa-solid fa-location-dot"></i></div>
                <h4>Visit Our Store</h4>
                <p>123 Luxury Avenue, New York, NY 10001</p>
                <a href="#" class="box-link">Get Directions →</a>
            </div>
            <div class="info-box">
                <div class="icon-circle"><i class="fa-regular fa-clock"></i></div>
                <h4>Business Hours</h4>
                <p>Mon-Sat: 9AM - 8PM<br>Sunday: Closed</p>
                <a href="#" class="box-link">View Schedule →</a>
            </div>
            <div class="info-box">
                <div class="icon-circle"><i class="fa-solid fa-envelope"></i></div>
                <h4>Email Us</h4>
                <p>info@luxury.com<br>We reply within 24h</p>
                <a href="#" class="box-link">Send Email →</a>
            </div>
            <div class="info-box">
                <div class="icon-circle"><i class="fa-brands fa-whatsapp"></i></div>
                <h4>WhatsApp</h4>
                <p>+1 (234) 567-890<br>Available 24/7</p>
                <a href="#" class="box-link">Chat Now →</a>
            </div>
        </div>
    </div>
</section>

<section class="map-section-full section-padding">
    <div class="container">
        <div class="map-wrapper-centered">
            <div class="map-container-box">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.412153497161!2d-73.987853123414!3d40.74844053861213!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sin!4v1704450000000!5m2!1sen!2sin"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

<section class="send-message-full section-padding">
    <div class="container">
        <div class="form-card-main">
            <p class="form-label-top"><b>SEND A MESSAGE</b></p>
            <h3 class="form-main-title">Let's Start a Conversation</h3>

            <form action="#" class="modern-form-layout">
                <div class="form-row">
                    <div class="input-group">
                        <label>Full Name *</label>
                        <input type="text" placeholder="John Doe" required>
                    </div>
                    <div class="input-group">
                        <label>Email Address *</label>
                        <input type="email" placeholder="john@example.com" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group">
                        <label>Phone Number</label>
                        <input type="text" placeholder="+1 (555) 123-4567">
                    </div>
                    <div class="input-group">
                        <label>Subject *</label>
                        <input type="text" placeholder="Product Inquiry" required>
                    </div>
                </div>
                <div class="input-group full-width">
                    <label>Your Message *</label>
                    <textarea rows="6" placeholder="Tell us what you're looking for..."></textarea>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-submit-gold"><i class="fa-solid fa-paper-plane"></i> Send
                        Message</button>
                    <a href="#" class="btn-whatsapp-green"><i class="fa-brands fa-whatsapp"></i> WhatsApp</a>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="faq-modern-section section-padding">
    <div class="container">
        <div class="text-center faq-header">
            <p class="faq-subtitle">COMMON QUESTIONS</p>
            <h2 class="faq-main-title">Frequently Asked Questions</h2>
        </div>
        <div class="faq-grid-layout">
            <div class="faq-card-item">
                <div class="faq-question-head"><i class="fa-regular fa-circle-check"></i> What are your shipping
                    options?</div>
                <p class="faq-answer">We offer free standard shipping on orders over $100. Express and international
                    shipping available.</p>
            </div>
            <div class="faq-card-item">
                <div class="faq-question-head"><i class="fa-regular fa-circle-check"></i> How can I track my order?
                </div>
                <p class="faq-answer">Once shipped, you'll receive a tracking number via email to monitor your delivery.
                </p>
            </div>
            <div class="faq-card-item">
                <div class="faq-question-head"><i class="fa-regular fa-circle-check"></i> What is your return policy?
                </div>
                <p class="faq-answer">We accept returns within 30 days of purchase. Items must be unused and in original
                    packaging.</p>
            </div>
            <div class="faq-card-item">
                <div class="faq-question-head"><i class="fa-regular fa-circle-check"></i> Do you offer gift wrapping?
                </div>
                <p class="faq-answer">Yes! Premium gift wrapping is available at checkout for a special touch.</p>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>