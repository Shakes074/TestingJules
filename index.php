<?php require_once 'templates/header.php'; ?>

<div class="hero-section text-center text-white bg-dark py-5">
    <div class="container">
        <h1 class="display-4">Plan Your Perfect Event</h1>
        <p class="lead">From intimate gatherings to large-scale corporate functions, we provide the tools to make your event a success.</p>
    </div>
</div>

<div class="container my-5">
    <div class="row text-center">
        <div class="col-md-6">
            <div class="planner-section p-4 border rounded shadow-sm">
                <h2>Self Planner</h2>
                <p>Perfect for individuals organizing personal events like weddings, birthdays, or anniversaries. Get access to all the tools you need to plan seamlessly.</p>
                <a href="register_client.php" class="btn btn-primary">Start Planning</a>
            </div>
        </div>
        <div class="col-md-6">
            <div class="planner-section p-4 border rounded shadow-sm">
                <h2>Event Planner</h2>
                <p>Designed for professional event planners managing multiple clients and complex events. Streamline your workflow and collaborate with vendors.</p>
                <a href="register_planner.php" class="btn btn-secondary">Manage Events</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
