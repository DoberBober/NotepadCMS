<?php
header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>NotepadCMS</title>
</head>
<body>


<?php if ($_COOKIE['auth']) { ?>
	<?php
		if ($_COOKIE['auth']) {
			$filesList = explode(",", ($_COOKIE['filesList']));
		};
	?>

	<div class="notepad">
		<form id="notepad__filePicker" class="notepad__filePicker filePicker" action="" method="POST">
			<div class="filePicker__wrapper">
				<?php foreach($filesList as $el){
					echo '<input type="radio" name="fileList" class="filePicker__input visually-hidden" id="' . $el . '" value="' . $el . '">';
					echo '<label class="filePicker__label" for="' . $el . '">' . $el . '</label>';
				}; ?>
			</div>
			<button class="filePicker__submit" type="submit"></button>
			<button type="button" class="filePicker__exit filePicker__exit--close"></button>
			<button type="button" class="filePicker__exit filePicker__exit--cancel"></button>
		</form>

		<form id="notepad__fileEditor" class="notepad__fileEditor" action="" method="POST">

			<div class="header">
				<img class="header__icon" src="notepadIcon.png" alt="logo" width="16" height="16">
				<input class="notepad__fileName" name="notepad__fileName" readonly tabIndex="-1">
				<span class="header__cmsName"> — NotepadCMS</span>
				<img class="header__toolbar" src="titleBarButtons.png" alt="logo" width="51" height="16">
				<button type="button" class="logOut" onClick="deleteAllCookies()" aria-label="Getting out of here"></button>
			</div>
			<ul class="menu">
				<li>
					<a class="menu__file" href="#"><i>F</i>ile</a>
					<ul class="menu__submenu">
						<li><span>New</span></li>
						<li><a class="menu__open" href="#">Open...</a></li>
						<li><button type="submit" class="menu__save" href="#">Save</button></li>
						<li><span>Save as...</span></li>
						<li><span>Page setup...</span></li>
						<li><span>Print...</span></li>
						<li><span>Exit</span></li>
					</ul>
				</li>
				<li><span><i>E</i>dit</span></li>
				<li><span>F<i>o</i>rmat</span></li>
				<li><span><i>V</i>iew</span></li>
				<li><span><i>H</i>elp</span></li>
			</ul>

			<textarea class="notepad__el notepad__el--editor" name="editor" id="editor"></textarea>
		</form>
	</div>
<?php } else { ?>
	<form id="signin" class="signin" action="" method="POST">
		<h1>Lasciate ogni speranza, voi ch'entrate.</h1>
		<input type="text" name="login" placeholder="Login" aria-label="Your login" required>
		<input type="password" name="password" placeholder="Password" aria-label="Your password" required>
		<div class="captcha">
			<img src="captcha.gif" width="268" height="66" alt="">
		</div>
		<input type="submit">
	</form>
<?php }; ?>

<style>
html{box-sizing:border-box}
*,*::before,*::after{box-sizing:inherit}
body{min-width:640px;height:100vh;margin:0;font-family: sans-serif;display:flex;align-items:center;justify-content:center;}
img{max-width: 100%;height: auto;}
.visually-hidden{position:absolute;width:1px;height:1px;margin:-1px;padding:0;border:none;overflow:hidden;white-space:nowrap;clip:rect(0,0,0,0);-webkit-clip-path:inset(100%);clip-path:inset(100%);}
</style>

<?php if (!$_COOKIE['auth']) { ?>
<style>
.signin{position:fixed;left:50%;top:50%;transform:translate(-50%,-50%);width:310px;border:1px solid #000;padding:20px;}
.signin h1{margin:0;font-size:20px;}
.signin input{display:block;width:100%;margin-top:15px;border:1px solid #000;padding:10px;}
.captcha{position:relative;margin-top:10px;display:none;overflow:hidden;max-height:70px;}
.captcha img{display:block;}
.captcha::before{content:'';position:absolute;left:0;top:0;width:100%;height:66px;visibility:visible;z-index:-1;background:url(captcha--ok.jpg) center center no-repeat;background-size:cover;background-position:0 100%;}
.signin input[name="password"]:valid + .captcha{display:block;animation:captcha 1s 5s forwards;}
@keyframes captcha{
	0%{visibility:visible;}
	1%{visibility:hidden;}
	100%{visibility:hidden;max-height:0;}
}
</style>
<script>
window.addEventListener("load", function () {
	function sendData(fileName, form) {
		var XHR = new XMLHttpRequest();
		var FD = new FormData(form);
		XHR.addEventListener("load", function(event) {
			if(this.responseText == "0"){
				alert("You have no power here!")
			} else if(this.responseText == "1"){
				location.reload();
			}
		});
		XHR.addEventListener("error", function(event) {
			alert('And there is only one thing I want to tell you: "not today".');
		});
		XHR.open("POST", fileName);
		XHR.send(FD);
	}
	var signin = document.getElementById("signin");
	signin.addEventListener("submit", function (event) {
		event.preventDefault();
		sendData('signin.php', signin);
	});
});
</script>
<?php } else { ?>
<style>
.logOut{position:absolute;width:16px;height:16px;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;}
.notepad{width: 100%;max-width:1200px;}
.notepad__el{display:block;margin:0 auto 20px;padding:10px;}
.notepad__el--fileChoose{margin-bottom:20px;}
.notepad__el--editor{height:50vh;font-family:sans-serif;border:2px solid #003399;border-top:none;width: 100%;padding: 5px 5px 0;resize:none;}
.filePicker{width:563px;height:455px;padding:70px 15px 110px 107px;position:fixed;left:50%;top:50%;transform:translate(-50%,-50%);z-index:10;background:url(selectWindow.png) center center no-repeat;display:none;}
.filePicker--visible{display:block;}
.filePicker__wrapper{position:relative;overflow:auto;display:flex;width:100%;height:100%;flex-wrap:wrap;align-items:flex-start;}
.filePicker__submit{position:absolute;right:11px;bottom:75px;width:74px;height:22px;border:none;background:none;cursor:pointer;}
.filePicker__exit{border:none;background:none;padding:0;position:absolute;cursor:pointer;}
.filePicker__exit--close{right:7px;top:7px;width:19px;height:19px;}
.filePicker__exit--cancel{right:11px;bottom:49px;width:74px;height:22px;}
.filePicker__label{width:80px;margin:0 0 15px 5px;padding:58px 3px 5px;background:url(fileIcon.png) center 5px no-repeat;font-size:13px;text-align:center;}
.filePicker__label:nth-of-type(5n){margin-left:0;}
.filePicker__input:focus + .filePicker__label,.filePicker__input:checked + .filePicker__label{background-color:#a4cffd;border-radius:3px;}
.menu{width:100%;height:32px;display:flex;align-items:center;margin:0;padding:0;list-style:none;background-color:#ece9d8;border-left:2px solid #003399;border-right:2px solid #003399;border-bottom:1px solid #999;}
.menu > li{position:relative;}
.menu > li > a{display:block;padding:7px 0 7px 10px;}
.menu__submenu{display:none;width:260px;margin:1px 0 0;padding:5px 0;list-style:none;position:absolute;left:0;top:100%;background:#f2f3f2;border-right:1px solid #999;border-bottom:1px solid #999;}
.menu__submenu::before{content:'';position:absolute;left:0;bottom:100%;width:100%;height:1px;z-index:1;}
.menu__submenu a,.menu__submenu span,.menu__submenu button{display:block;width:100%;margin:0;padding:4px 10px;background:none;border:none;text-align:left;font-family:sans-serif;}
.menu__submenu a:hover,.menu__submenu a:focus,.menu__submenu button:hover,.menu__submenu button:focus{background-color:#91c9f7;cursor:pointer;}
.menu span,.menu a,.menu button{font-size:14px;}
.menu > li > span{margin-left:15px;}
.menu a{text-decoration:none;color:#000;}
.menu a:hover + .menu__submenu,.menu__submenu:hover{display:block;}
.menu i{font-style:normal;text-decoration:underline;}
.notepad__fileEditor{position:relative;width:90%;margin:0 auto;overflow:hidden;border-top-left-radius:5px;border-top-right-radius:5px;}
.header{position:relative;font-weight:bold;display:flex;width:100%;height:32px;padding:8px 10px;background:linear-gradient(to bottom,#8caae6 0%,#003399 10%,#6487dc 100%);color:#fff;border-left:2px solid #003399;border-right:2px solid #003399;}
.header__icon{margin-right:5px;}
.notepad__fileName{width:0;border:none;margin:0;padding:0;font-size:14px;background-color:transparent;color:#fff;font-weight:bold;}
.notepad__fileName:active,.notepad__fileName:focus{outline:none;}
.header__cmsName{display:flex;align-items:center;font-size:14px;}
.notepad__fileName:not([style^="width"]) + .header__cmsName::before{content:"Untitled";margin-right:4px;}
.header__toolbar{margin-left:auto;}
</style>

<script>
var formFilePicker = document.querySelector('.filePicker');
var fileChoose = document.querySelector('.filePicker__wrapper');
var formFileEditor = document.querySelector('.notepad__fileEditor');
var fileEditorBody = document.querySelector('.notepad__el--editor');
var choosedFileName = document.querySelector('.notepad__fileName');
var menuOpenFile = document.querySelector('.menu__open');
var closeFilePicker = document.querySelectorAll('.filePicker__exit');

// Add "unsave"-class.
fileEditorBody.addEventListener("keyup", function(event){
	if(choosedFileName.value){
		notepad__fileEditor.classList.add("unsave");
	}
})

// Open menu for "File".
menuOpenFile.addEventListener('click', function(event){
	event.preventDefault();
	formFilePicker.classList.add('filePicker--visible');
})

// Close file selection window.
for(var i=0; i<closeFilePicker.length; i++){
	closeFilePicker[i].addEventListener('click', function(){
		formFilePicker.classList.remove('filePicker--visible');
	})
}

// Save.
formFileEditor.addEventListener("submit", function (event) {
	event.preventDefault();
	notepad__fileEditor.classList.remove("unsave")
	sendData('save.php', formFileEditor);

	function sendData(fileName, form) {
		var XHR = new XMLHttpRequest();
		var FD = new FormData(form);
		XHR.addEventListener("load", function(event) {
			if(this.responseText == 1){
				console.log("Success!");
			}
		});
		XHR.addEventListener("error", function(event) {
			alert('And there is only one thing I want to tell you: "not today".');
		});
		XHR.open("POST", fileName);
		XHR.send(FD);
	}
});

// Choose file.
formFilePicker.addEventListener("submit", function (event) {
	event.preventDefault();
	if(notepad__fileEditor.classList.contains("unsave")){
		if (confirm('Are you sure you want to change file? This file in not saved.')) {
			formFileEditor.classList.remove("unsave");
			send();
		} else {
			fileChoose.querySelector("input[value='" + choosedFileName.value + "']").checked = true;
		}
	} else {
		send();
	}

	formFilePicker.classList.remove("filePicker--visible");

	function send(){
		sendData('fileChoose.php', formFilePicker);

		function sendData(fileName, form) {
			var XHR = new XMLHttpRequest();
			var FD = new FormData(form);
			XHR.addEventListener("load", function(event) {
				if(this.responseText){
					fileEditorBody.value = JSON.parse(this.responseText)[0];
					choosedFileName.value = JSON.parse(this.responseText)[1];
					choosedFileName.style.width = (choosedFileName.value.length * 7 + 5) + 'px';
				} else {
					fileEditorBody.value = "";
					choosedFileName.value = "";
					choosedFileName.removeAttribute("style");
				}
			});
			XHR.addEventListener("error", function(event) {
				alert('And there is only one thing I want to tell you: "not today".');
			});
			XHR.open("POST", fileName);
			XHR.send(FD);
		}
	}
});

// Delete cookies (log out).
function deleteAllCookies() {
    var cookies = document.cookie.split(";");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
    location.reload();
};
</script>
<?php }; ?>

</body>
</html>