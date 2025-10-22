@extends('frontend.layouts.main')

@section('main.container')



<section id="home" class="home container-fluid p-0">

<div class="row hero">
  <div class="col pl-3 ml-sm-5 p-0">
    <h1 class="text1">Interior Design</h1>
    <h3 class="text2">Architechture services</h3>
  </div>
</div>

<div class="counting">

<div class="box">
  <h1 class="count" data-count="1200">1200+</h1>
  <h3>working hours</h3>
</div>

<div class="box">
  <h1 class="count" data-count="15">15+</h1>
  <h3>awards</h3>
</div>

<div class="box">
  <h1 class="count" data-count="1000">1000+</h1>
  <h3>clients</h3>
</div>

<div class="box">
  <h1 class="count" data-count="840">840+</h1>
  <h3>projects</h3>
</div>

</div>

</section>

 <!-- home section ends -->










 <!-- service section starts  -->

<section id="service" class="service">

<h1 class="heading">our services</h1>

<div class="box-container mx-auto">

  <div class="box">
    <div class="fas fa-palette"></div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex unde assumenda odio sint voluptatibus sed, quae deserunt fugit voluptates nisi!</p>
  </div>

  <div class="box">
    <div class="fas fa-tools"></div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex unde assumenda odio sint voluptatibus sed, quae deserunt fugit voluptates nisi!</p>
  </div>

  <div class="box">
    <div class="fas fa-house-user"></div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex unde assumenda odio sint voluptatibus sed, quae deserunt fugit voluptates nisi!</p>
  </div>

  <div class="box">
    <div class="fas fa-couch"></div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex unde assumenda odio sint voluptatibus sed, quae deserunt fugit voluptates nisi!</p>
  </div>

  <div class="box">
    <div class="fas fa-bed"></div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex unde assumenda odio sint voluptatibus sed, quae deserunt fugit voluptates nisi!</p>
  </div>

  <div class="box">
    <div class="fas fa-bath"></div>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ex unde assumenda odio sint voluptatibus sed, quae deserunt fugit voluptates nisi!</p>
  </div>

</div>

</section>

<!-- service section ends -->








<!-- project section starts   -->

<section id="project" class="project">

  <div class="heading">our projects</div>
  
  <div class="box-container mx-auto">
  
  <div class="box">
    <a href="/frontend/images/image1.jpg" title="kitchen">
      <img src="/frontend/images/image1.jpg" alt="">
    </a>
  </div>
  
  <div class="box">
    <a href="/frontend/images/image2.jpg" title="office">
      <img src="/frontend/images/image2.jpg" alt="">
    </a>
  </div>
  
  <div class="box">
    <a href="/frontend/images/image3.jpg" title="bathroom">
      <img src="/frontend/images/image3.jpg" alt="">
    </a>
  </div>
  
  <div class="box">
    <a href="/frontend/images/image4.jpg" title="dining">
      <img src="/frontend/images/image4.jpg" alt="">
    </a>
  </div>
  
  <div class="box">
    <a href="/frontend/images/image5.jpg" title="lounge">
      <img src="/frontend/images/image5.jpg" alt="">
    </a>
  </div>
  
  <div class="box">
    <a href="/frontend/images/image6.jpg" title="console">
      <img src="/frontend/images/image6.jpg" alt="">
    </a>
  </div>
  
  </div>
  
  </section>

<!-- project section ends -->









<!-- contact section starts  -->

<section id="contact" class="contact">

<h1 class="heading">contact us</h1>

<div class="contact-box-container mx-auto">

<div class="contact-box">
  <i class="fas fa-map-marker-alt"></i>
  <h3>Karachi, Pakistan - 400104</h3>
</div>

<div class="contact-box">
  <i class="fas fa-envelope"></i>
  <h3>spaceAlchemy@gmail.com</h3>
</div>

<div class="contact-box">
  <i class="fas fa-phone"></i>
  <h3>+92457654287</h3>
</div>

</div>

<div class="form-container mx-auto">

<form action="">

  <div class="inputBox">
    <input type="text" placeholder="first name">
    <input type="text" placeholder="last name">
  </div>
  <input type="email" placeholder="e-mail">
  <textarea name="" id="" cols="30" rows="10" placeholder="message"></textarea>
  <input type="submit" value="send">

</form>

</div>


</section>

<!-- contact section ends -->







@endsection




