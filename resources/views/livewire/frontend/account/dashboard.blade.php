<div class="col-lg-9">
    <div class="filter-button dash-filter dashboard">
        <button class="btn btn-solid-default btn-sm fw-bold filter-btn">Show Menu</button>
    </div>

    <div class="dashboard-right">
        <div class="dashboard">
            <div class="page-title title title1 title-effect">
                <h2>My Dashboard</h2>
            </div>
            <div class="welcome-msg">
                <h6 class="font-light">Hello, <span>{{ Str::ucfirst(Auth::user()->username) }}</span></h6>
                <p class="font-light">From your My Account Dashboard you have the ability to
                    view a snapshot of your recent account activity and update your account
                    information. Select a link below to view or edit information.</p>
            </div>

            <div class="order-box-contain my-4">
                <div class="row g-4">


                </div>
            </div>


        </div>
    </div>

</div>
