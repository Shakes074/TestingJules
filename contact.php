<?php require_once 'templates/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">Contact Us</h2>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <p class="text-center">Have questions or need support? Fill out the form below, and our team will get back to you as soon as possible.</p>
            <form>
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Your Email</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" rows="5" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Send Message</button>
            </form>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
