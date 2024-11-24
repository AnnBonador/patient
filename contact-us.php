<?php
include('admin/config/dbconn.php');
include('main/header.php');
include('main/topbar.php');
?>
<main id="main">
  <section class="breadcrumbs">
    <div class="container">
      <div class="d-flex justify-content-between align-items-center">
        <h2>Contact Us</h2>
        <ol>
          <li><a href="index.php">Home</a></li>
          <li>Contact Us</li>
        </ol>
      </div>
    </div>
  </section>
  <section id="contact" class="contact">
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <?php
          if (isset($success)) {
            echo 'Thanks';
          }
          ?>
          <h4 class="mb-4 text-primary">Contact</h4>
          <p class="description">Consult with our team online by filling out the form below. If you have specific inquiries regarding our services, please don't hesitate to get in touch. We will respond as soon as possible.</p>
        </div>
      </div>
    </div>

    <div>
      <iframe style="border:0; width: 100%; height: 350px;" src="<?= $map ?>" frameborder="0" allowfullscreen></iframe>
    </div>

    <div class="container">
      <div class="row mt-5">

        <div class="col-lg-4">
          <div class="info">
            <div class="address">
              <i class="bi bi-geo-alt"></i>
              <h4>Location:</h4>
              <p><?= $address ?></p>
            </div>

            <div class="email">
              <i class="bi bi-envelope"></i>
              <h4>Email:</h4>
              <p><?= $email ?></p>
            </div>

            <div class="phone">
              <i class="bi bi-phone"></i>
              <h4>Call:</h4>
              <p><?= $mobile ?></p>
            </div>

          </div>

        </div>

        <div class="col-lg-8 mt-5 mt-lg-0">
          <form id="frmDemo" class="php-email-form" method="post">
            <div class="row">
              <div class="col-md-6 form-group">
                <input type="text" name="name" id="name" placeholder="Your Name" class="form-control" required />
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <input type="email" name="email" id="email" placeholder="Your Email" class="form-control" required />
              </div>
            </div>
            <div class="form-group mt-3">
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
            </div>
            <div class="form-group mt-3">
              <textarea class="form-control" name="message" id="message" rows="5" placeholder="Message" required></textarea>
            </div>
            <div class="my-3">
              <div class="alert alert-danger" role="alert" id="error_message" style="display:none;"></div>
              <div class="alert alert-success" role="alert" id="success_message" style="display:none;"></div>
            </div>
            <div class="text-center"><button name="btn-submit" id="btn-submit" type="submit">Send Message</button></div>
          </form>
        </div>

      </div>

    </div>
  </section>

</main>
<?php
include('main/footer.php');
include('main/scripts.php');
?>