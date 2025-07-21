<?php require_once 'templates/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">How to Use EventPlanner</h2>
    <div class="accordion" id="howToUseAccordion">

        <!-- Step 1 for Clients -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    <strong>Step 1: For Clients & Planners - Register and Define Your Role</strong>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#howToUseAccordion">
                <div class="accordion-body">
                    Choose your role as a 'Self Planner' for personal events or an 'Event Planner' for professional services. Fill out the simple registration form to create your account.
                </div>
            </div>
        </div>

        <!-- Step 2 for Service Providers -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    <strong>Step 2: For Service Providers - Join Our Network</strong>
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#howToUseAccordion">
                <div class="accordion-body">
                    Register as a 'Company' or 'Service Provider' through our "Work with Us" section. Complete your profile to showcase your services to a wide audience of potential clients.
                </div>
            </div>
        </div>

        <!-- Step 3 General -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <strong>Step 3: Verification and Approval</strong>
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#howToUseAccordion">
                <div class="accordion-body">
                    Verify your email using the OTP sent to you. After verification, our admin team will review and approve your account to ensure the security and quality of our network.
                </div>
            </div>
        </div>

        <!-- Step 4 General -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingFour">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    <strong>Step 4: Plan, Book, and Manage</strong>
                </button>
            </h2>
            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#howToUseAccordion">
                <div class="accordion-body">
                    Once approved, log in to your personalized dashboard. Clients can start planning events and booking services, while providers can manage bookings and showcase their work.
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once 'templates/footer.php'; ?>
