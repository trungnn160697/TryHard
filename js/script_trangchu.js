/*
* @Author: ngoc trung
* @Date:   2017-09-19 21:44:28
* @Last Modified by:   ngoc trung
* @Last Modified time: 2017-09-25 23:51:27
*/
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
function check_username(name){

	var s = name.toLowerCase();
	if(/^[a-zA-Z0-9]*$/.test(s) == false) {
   			return 0;
	}
	return name.length == 0?0:1;
}
function check_dangki(){
	var dk_username = document.getElementById('dk_username').value;
	var dk_password = document.getElementById('dk_password').value;
	var dk_password2 = document.getElementById('dk_password2').value;
	var dk_hoten = document.getElementById('dk_hoten').value;
	var dk_email = document.getElementById('dk_email').value;

	if(dk_username.indexOf(' ')!=-1){
		document.getElementById('cb_username').innerHTML = 'username không được chứa khoảng trắng';
	}
	else{
		document.getElementById('cb_username').innerHTML ="";
	}
	if(check_username(dk_username)==0){
		document.getElementById('cb_username').innerHTML = 'username chỉ được chứa số hoặc chữ cái';
	}
	else{
		document.getElementById('cb_username').innerHTML ="";
	}
	if(dk_password.length<06){
		document.getElementById('cb_password').innerHTML = 'Mật khẩu phải có ít nhất 6 kí tự'
	}
	else{
		document.getElementById('cb_password').innerHTML = "";
	}
	if(dk_hoten.length<=0){
		document.getElementById('cb_hoten').innerHTML = 'Phải điền đầy đủ họ tên'
	}
	else{
		document.getElementById('cb_hoten').innerHTML = "";
	}
	if(dk_email.length<=0){
		document.getElementById('cb_email').innerHTML = 'Phải điền đầy đủ email';
	}
	else{
		document.getElementById('cb_email').innerHTML = "";
	}
	if(!validateEmail(dk_email)){
		document.getElementById('cb_email').innerHTML = 'Phải điền đúng định dạng email';
	}
	else{
		document.getElementById('cb_email').innerHTML = "";
	}
	if(dk_password!=dk_password2){
		document.getElementById('cb_password2').innerHTML = "Nhập đúng mật khẩu vừa tạo";
	}
	else{
		document.getElementById('cb_password2').innerHTML = "";
	}
	if(dk_password==dk_password&&dk_username.length>0&&dk_password.length>=6&&dk_hoten.length>0&&dk_email.length>0&&dk_username.indexOf(' ')==-1&&check_username(dk_username)!=0&&validateEmail(dk_email)){
		document.getElementById('cb_username').innerHTML ="";
		document.getElementById('cb_password').innerHTML = "";
		document.getElementById('cb_hoten').innerHTML = "";
		document.getElementById('cb_email').innerHTML = "";
		return true;
	}
	return false;	
}
function dk_reset(){
	document.getElementById('dk_username').value="";
	document.getElementById('dk_password').value="";
	document.getElementById('dk_hoten').value="";
	document.getElementById('dk_email').value="";
}
function check_capnhat(){
	var password_cu = document.getElementById('cu_password').value;
	var cn_password = document.getElementById('cn_password').value;
	var cn_password2 = document.getElementById('cn_password2').value;
	var cn_hoten = document.getElementById('cn_hoten').value;
	var cn_email = document.getElementById('cn_email').value;

	
	if(cn_password==cn_password2 && 
		cn_password.length >= 6 &&
		cn_hoten.length>0 &&
		cn_email.length>0 &&
		validateEmail(cn_email)){
		document.getElementById('cb_password_cn').innerHTML = "";
		document.getElementById('cb_hoten_cn').innerHTML = "";
		document.getElementById('cb_email_cn').innerHTML = "";
		document.getElementById('formupdate').submit();
		document.getElementById('usubmit').click();
		return true;
	}
	if(cn_hoten.length<=0){
		document.getElementById('cb_hoten_cn').innerHTML = 'Phải điền đầy đủ họ tên'
	}
	else{
		document.getElementById('cb_hoten_cn').innerHTML = "";
	}
	if(cn_email.length<=0){
		document.getElementById('cb_email_cn').innerHTML = 'Phải điền đầy đủ email';
	}
	else{
		document.getElementById('cb_email_cn').innerHTML = "";
	}
	if(!validateEmail(cn_email)){
		document.getElementById('cb_email_cn').innerHTML = 'Phải điền đúng định dạng email';
	}
	else{
		document.getElementById('cb_email_cn').innerHTML = "";
	}
	if(cn_password.length<6){
		document.getElementById('cb_password_cn').innerHTML = 'Mật khẩu phải có ít nhất 6 kí tự'
	}
	else{
		document.getElementById('cb_password_cn').innerHTML = "";
	}
	if(cn_password!=cn_password2){
		document.getElementById('cb_password_cn2').innerHTML = "Nhập đúng mật khẩu vừa nhập";
	}
	else{
		document.getElementById('cb_password_cn2').innerHTML = "";
	}

	return false;	
}