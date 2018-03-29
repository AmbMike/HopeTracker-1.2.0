<?php
    /** ####### IMPORTANT ###### */
    /** Make sure to add this function to tie in debug output
     *  public static function out($data){
     * global $DEBUGOUT;
     * $DEBUGOUT = $data;
     * return $data;
     * }
     */
?>
<style>
	#toggleWidthErrorWindow{
		display: none;
		z-index: 1000;
		height: 100%;
		overflow-y: auto;
		overflow-x: hidden;
		background: #1a1a1a;
		-webkit-transition: all 0.5s ease;
		-moz-transition: all 0.5s ease;
		-o-transition: all 0.5s ease;
		transition: all 0.5s ease;
		position: fixed;
		top: 0;
		width:100%;
		max-width: 335px;
		margin: 0;
		padding: 15px;
		list-style: none;
	}
	#toggleWidthErrorWindow.active{
		display: block;
	}
	#toggleWidthErrorWindow h1{
		font-size: 24px;
		font-weight: bold;
		padding-bottom: 10px;
		margin: 15px 0;
		text-transform: uppercase;
		color: #d6d6d6;
		border-bottom: 1px solid rgba(255,255,255,.08);
	}
	#toggleWidthErrorWindow .area-label {
		background: #0c0c0c;
		color: #d6d6d6;
		padding: 15px;
		margin: 0;
		width: 100%;
		border-radius: 3px 3px 0 0;
	}
	#toggleWidthErrorWindow .box-1{
		background: rgba(255,255,255,.03);
		border-radius: 0 0 3px 3px;
	}

	#toggleWidthErrorWindow.full-width{
		max-width: 100%;
	}
	.error-sidebar-nav {
		margin: 20px 0;
		background: rgba(255,255,255,.3);
	}
	.error-sidebar-nav .open>a {
		background-color: transparent !important;
	}
	.error-sidebar-nav li {
		display: block;
		padding: 0;
		margin: 0;
	}

	.error-sidebar-nav li.dropdown-toggle{
		background-color: transparent;
	}
	.error-sidebar-nav li a {
		display: block;
		color: #ddd;
		text-decoration: none;
		padding: 8px 15px ;
		margin: 0;
	}
	.error-sidebar-nav li a:hover,.error-sidebar-nav li a:active,.error-sidebar-nav li a:focus {
		background-color: transparent;
	}
	.error-sidebar-nav .dropdown-menu {
		position: relative;
		width: 100%;
		padding: 0;
		margin: 0;
		border-radius: 0;
		border: none;
		box-shadow: none;
		margin-bottom: 15px;
		background-color: transparent;
	}
	.error-sidebar-nav .dropdown-menu li{
		margin-left: 15px;
		background-color: rgba(255,255,255,0.04);
	}
	.error-sidebar-nav .dropdown-menu li a:hover,.error-sidebar-nav .dropdown-menu li a:active,.error-sidebar-nav .dropdown-menu  li a:focus {
		background-color: rgba(255,255,255,0.04);
		color: #d6d6d6;
	}

	#toggleWidthErrorWindow .error-output{
		padding: 15px;
		color: #333333;
		background: #e8e8e8;
	}
	#mg-error-window .show-window {
		position: fixed;
		width: 130px;
		height: 55px;
		text-align: center;
		bottom: 0;
		right: 0;
		background: black;
		color: rgba(255,255,255,.6);
		padding: 10px;
		border-radius: 20px 0 0 0;
		font-size: 16px;
		cursor: pointer;
	}
</style>
<script>
    function toggleWidthErrorWindow() {
        var element = document.getElementById("toggleWidthErrorWindow");
        element.classList.toggle("full-width");
    }
    function toggleErrorWindow() {
        var element = document.getElementById("toggleWidthErrorWindow");
        element.classList.toggle("active");
    }
</script>
<div id="mg-error-window">
	<div class="show-window" onclick="toggleErrorWindow()">
		Toggle Debug Window
	</div>
	<nav class="navbar navbar-inverse navbar-fixed-top" id="toggleWidthErrorWindow" role="navigation">
		<h1>Error Panel</h1>
		<button class="btn btn-primary" onclick="toggleWidthErrorWindow()">Toggle Width</button>
		<ul class="nav error-sidebar-nav box-1">
			<li class="area-label">Action Functions - Pages</li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Course Page <span class="caret"></span></a>
				<ul class="dropdown-menu" role="menu">
					<li><a role="button" onclick="resetActivitySession();">Reset Session</a></li>
					<li><a role="button" onclick="resetCourseIntro();">Reset Intro</a></li>
				</ul>
			</li>
		</ul>
		<h2 class="area-label">Error Output</h2>
		<div class="error-output box-1">
			<?php
global $DEBUGOUT;
			    if($DEBUGOUT != null){
				    Debug::data($DEBUGOUT);
			    }
			?>
		</div>
	</nav>
</div>
