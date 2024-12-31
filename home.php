<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href= "styles.css"/>
    <title> EasyRide</title>
  </head>
  <body>
    <header>
      <nav>
        <div class="nav__header">
          <div class="nav__logo">
            <a href="#">EasyRide</a>
          </div>
          <div class="nav__menu__btn" id="menu-btn">
            <i class="ri-menu-line"></i>
          </div>
        </div>
        <ul class="nav__links" id="nav-links">
          <li><a href="#home">Home</a></li>
          <li><a href="logginn.php">Rent</a></li>
          <li><a href="#service">Services</a></li>
          <li><a href="#experience">Experience</a></li>
          <li><a href="#contact">Contact</a></li>
          <li class="nav__links__btn">
            <button  class="btn">Sign Up</button>
          </li>
          <li class="nav__links__btn">
            <button  class="btn">Sign In</button>
          </li>
        </ul>
        <div class="nav__btns">
          <a href="signup.php"><button class="btn btn__primary">Sign Up</button></a>
          <a href="logginn.php"><button class="btn btn__secondary">Sign In</button></a>
        </div>
      </nav>
      <div class="section__container header__container" id="home">
        <div class="header__image">
          <img src="imges\header.png" alt="header" />
        </div>
        <div class="headerr__content">
          <h1>Looking to save more on your rental car?</h1>
          <p>
           We offer a wide extend of rental cars to suit your needs ,
           Wether its a weekend travel or business trip
          </p>
          
        </div>
      </div>
    </header>


    <section class="section__container service__container" id="service">
      <div class="service__image">
        <img src="imges\services.png" alt="service" />
      </div>
      <div class="service__content">
        <p class="section__subheader">BEST SERVICES</p>
        <h2 class="section__header">
          Feel the best experience with our rental deals
        </h2>
        <ul class="service__list">
          <li>
            <span><i class="ri-price-tag-3-fill"></i></span>
            <div>
              <h4>Deals for every budget</h4>
              <p>
                From economy cars to luxury vehicles, we have something for
                everyone, ensuring you get the best value for your money.
              </p>
            </div>
          </li>
          <li>
            <span><i class="ri-wallet-fill"></i></span>
            <div>
              <h4>Best price guarantee</h4>
              <p>
                We ensure you get competitive rates in the market, so you can
                book with confidence knowing you're getting the best deal.
              </p>
            </div>
          </li>
          <li>
            <span><i class="ri-customer-service-fill"></i></span>
            <div>
              <h4>Support 24/7</h4>
              <p>
                Our dedicated team is available 24/7 to assist you with any
                questions or concerns, ensuring a smooth rental experience.
              </p>
            </div>
          </li>
        </ul>
      </div>
    </section>

    <section class="section__container experience__container" id="experience">
      <p class="section__subheader">CUSTOMER EXPERIENCE</p>
      <h2 class="section__header">
        We are ensuring the best customer experience
      </h2>
      <div class="experience__content">
        <div class="experience__card">
          <span><i class="ri-price-tag-3-fill"></i></span>
          <h4>Competitive pricing</h4>
        </div>
        <div class="experience__card">
          <span><i class="ri-money-rupee-circle-fill"></i></span>
          <h4>Easier Rent On Your Budget</h4>
        </div>
        <div class="experience__card">
          <span><i class="ri-bank-card-fill"></i></span>
          <h4>Most Felxible Payment Plans</h4>
        </div>
        <div class="experience__card">
          <span><i class="ri-award-fill"></i></span>
          <h4>The Best Extended Auto Warranties</h4>
        </div>
        <div class="experience__card">
          <span><i class="ri-customer-service-2-fill"></i></span>
          <h4>Roadside Assistance 24/7</h4>
        </div>
        <div class="experience__card">
          <span><i class="ri-car-fill"></i></span>
          <h4>Your Choice Of Mechanic</h4>
        </div>
        <img src="imges\experience.png" alt="experience" />
      </div>
    </section>

    

    <footer>
      <div class="section__container footer__container">
        <div class="footer__col">
          <h4>Our Products</h4>
          <ul class="footer__links">
            
            <li><a href="logginn.php">Cars</a></li>
            <li><a href="logginn.php">Packages</a></li>
            <li><a href="logginn.php">Features</a></li>
            <li><a href="logginn.php">Priceline</a></li>
          </ul>
        </div>
        <div class="footer__col">
          <h4>About EasyRide</h4>
          <ul class="footer__links">
            <li><a href="#service">Why EasyRide</a></li>
            <li><a href="#service">Our Story</a></li>
            
          </ul>
        </div>
        
        <div class="footer__col">
          <h4>Extras</h4>
          <ul class="footer__links">
           
            <li><a href="logginn.php">View Booking</a></li>
            <li><a href="logginn.php">New Offers</a></li>
          </ul>
        </div>
      </div>
      <div class="section__container footer__bar">
        <h4>EasyRide</h4>
        <p>Copyright © 2024 EasyRide . All rights reserved.</p>
        <ul class="footer__socials">
          
        </ul>
      </div>
    </footer>

    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="main.js"></script>
  </body>
</html>