<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="<?= base_url("admin"); ?>">Law Calendar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor03" aria-controls="navbarColor03" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor03">
    <ul class="navbar-nav mr-auto">
     <!--  <li class="nav-item">
        <?= anchor('cases','Cases',array('class' => 'nav-link active'));?>
      </li> -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url("rules"); ?>">Rules</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url("users"); ?>">Users</a>
      </li>
      <!--
      <li class="nav-item">
        <?= anchor('users','Users',array('class' => 'nav-link'));?>
      </li>
    -->
      <li class="nav-item">
        <!--a class="nav-link" href="#">About</a-->
      </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <a href="<?= base_url("home"); ?>"><button class="btn btn-secondary my-2 my-sm-0" type="button">User Dashboard</button></a>
      </form>
      <form class="form-inline my-2 my-lg-0">
        <a href="<?= base_url("adminSettings"); ?>"><button class="btn btn-secondary my-2 my-sm-0" type="button">Settings</button></a>
      </form>
      <form class="form-inline my-2 my-lg-0">
        <a href="<?= base_url("adminLogout"); ?>"><button class="btn btn-secondary my-2 my-sm-0" type="button">Logout</button></a>
      </form>
  </div>
</nav>
