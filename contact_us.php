<?php 
   
   require('header.php');
   
?>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Bike Buy</title>
    <link rel="stylesheet" href="css/contact_us.css" type = "text/css">
</head>
<body>

<section class="contact">
    <div class="container">
        <h1>Contact Us</h1>
        <p class="heading-text">
            We'd love to hear from you! Whether you're looking to buy a new or used bike,
            have questions about pricing, financing, or availability, our team is here to help.
        </p>

        <div class="contact-content">

            <!-- Contact Information -->
            <div class="contact-info">
                <h2>Get in Touch</h2>

                <div class="info-box">
                    <h3>📍 Address</h3>
                    <p>123 Bike Market Road, Shimla, Himachal Pradesh, India</p>
                </div>

                <div class="info-box">
                    <h3>📞 Phone</h3>
                    <p>+91 98765 43210</p>
                </div>

                <div class="info-box">
                    <h3>✉ Email</h3>
                    <p>info@bikebuy.com</p>
                </div>

                <div class="info-box">
                    <h3>🕒 Business Hours</h3>
                    <p>Monday - Saturday: 9:00 AM - 7:00 PM</p>
                    <p>Sunday: 10:00 AM - 4:00 PM</p>
                </div>
            </div>

            <!-- Contact Form -->
            <div class="contact-form">
                <h2>Send Us a Message</h2>

                <form action="#" method="post">

                    <input type="text" name="name" placeholder="Your Name" required>

                    <input type="email" name="email" placeholder="Your Email" required>

                    <input type="text" name="subject" placeholder="Subject" required>

                    <textarea name="message" rows="6" placeholder="Write your message..." required></textarea>

                    <button type="submit" class = "btn btn-primary">Send Message</button>

                </form>
            </div>

        </div>
    </div>
</section>

</body>

<?php 
   require('footer.php');
?>