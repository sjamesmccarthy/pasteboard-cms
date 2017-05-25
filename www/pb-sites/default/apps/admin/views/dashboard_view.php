<div id="main">
<h2>Welcome to the dashboard.</h2>
<p>This whole interface is going to be redesigned.</p>

<p><b>SESSION_DATA</b><br />
This is the data stored in the $_SESSION array</p>
<?= preint_r($_SESSION); ?>

<p><b>COOKIE_DATA</b><br />
This is the data stored in the $_COOKIE array</p>
<?= preint_r($_COOKIE); ?>
</div>