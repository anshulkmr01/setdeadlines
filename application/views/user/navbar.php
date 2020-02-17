
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?= base_url("home"); ?>">Law Calendar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <?= anchor('userCases','Cases',array('class' => 'nav-link'));?>
      </li>
      <li class="nav-item">
       <?= anchor('populatedCase','Deadlines',array('class' => 'nav-link'));?>
      </li>
      <li class="nav-item">
       <?= anchor('userRules','My Rules',array('class' => 'nav-link'));?>
      </li>
      <li class="nav-item">
        <?= anchor('home','Import Rules',array('class' => 'nav-link'));?>
      </li>
      <li class="nav-item">
        <!--a class="nav-link" href="#">About</a-->
      </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <?php if($this->session->userdata('adminId')){?>
        <a href="<?= base_url("users"); ?>"><button class="btn btn-secondary my-2 my-sm-0" type="button">All Users</button></a>
      <?php }?>
        <a href="<?= base_url("userProfile"); ?>"><button class="btn btn-secondary my-2 my-sm-0" type="button">Settings</button></a>
      <form class="form-inline my-2 my-lg-0">
        <a href="<?= base_url("userLogout"); ?>"><button class="btn btn-secondary my-2 my-sm-0" type="button">Logout</button></a>
      </form>
  </div>
</nav>