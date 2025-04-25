<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Service Desk</title>
    <link rel="icon" href="{{ asset('img/gd-logo.png') }}" type="image/png"/>
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('css/landing.css')}}"/>
</head>

<body>

<nav>
    <a href="/">Home</a>
    <div class="login-register">
        <a id="login" href="{{route('login')}}">Login</a>
        <a id="register" href="{{route('register')}}">Register</a>
    </div>
</nav>

<header>
    <img src="{{asset('img/gem-desk.png')}}" class="card-img-top" alt="gem-desk logo"
         style="width: 90px; height: auto;">
    <h1>Gem-Desk</h1>
    <p>Your One-Stop Solution for IT Support</p>
</header>


<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{asset('img/User.png')}}" class="card-img-top custom-card-img" alt="Card 1">
                <div class="card-body">
                    <h5 class="card-title">User</h5>
                    <p class="card-text custom-card-text">This feature focuses on the comprehensive management and
                        administration of user accounts within the system.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="{{asset('img/Organization.png')}}" class="card-img-top custom-card-img" alt="Card 2">
                <div class="card-body">
                    <h5 class="card-title">Organization Management</h5>
                    <p class="card-text custom-card-text">This feature facilitates the structured organization and
                        coordination of team hierarchies, workflows, and processes, ensuring seamless operational
                        management within an organization.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="{{asset('img/Service.png')}}" class="card-img-top custom-card-img" alt="Card 3">
                <div class="card-body">
                    <h5 class="card-title">Services Catalog</h5>
                    <p class="card-text custom-card-text">This feature offers a comprehensive catalog of services
                        provided by the organization, allowing users to easily browse, select, and request the services
                        they need.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src="{{asset('img/Asset.png')}}" class="card-img-top custom-card-img" alt="Card 1">
                <div class="card-body">
                    <h5 class="card-title">Asset Management</h5>
                    <p class="card-text custom-card-text">It provides tools for tracking and managing all organizational
                        assets, including hardware and software resources, ensuring efficient allocation and
                        maintenance.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="{{asset('img/Insiden.png')}}" class="card-img-top custom-card-img" alt="Card 2">
                <div class="card-body">
                    <h5 class="card-title">Incident Management</h5>
                    <p class="card-text custom-card-text">Focused on swiftly addressing and resolving unexpected issues
                        and incidents, this feature ensures minimal disruption and maintains service continuity</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="{{asset('img/Ticket.png')}}" class="card-img-top custom-card-img" alt="Card 3">
                <div class="card-body">
                    <h5 class="card-title">Ticket Management</h5>
                    <p class="card-text custom-card-text">A robust system for handling and tracking customer queries and
                        service requests, ensuring every issue is addressed in an organized and timely manner.</p>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <section>
                <h2>Welcome to Our Service Desk</h2>
                <p>Experience top-notch IT support with our dedicated service desk team. We are here to help you with
                    any
                    technical issues and inquiries you may have.</p>
                <a href="#contact" class="cta-button">Contact Us</a>
            </section>
        </div>

        <div class="col-md-6">
            <section>
                <h2>Contact Us</h2>
                <p>Have questions or need assistance? Feel free to reach out to us.</p>
                <p>Email: support@gemdesk.com</p>
                <p>Phone: (+62) 85695 470495</p>
            </section>
        </div>
    </div>
</div>

<footer>
    <p>&copy; 2023 Gem-Desk. All rights reserved.</p>
</footer>
</body>

</html>
