/*
* @Author: ngoc trung
* @Date:   2017-10-17 23:19:09
* @Last Modified by:   ngoc trung
* @Last Modified time: 2017-10-26 22:43:30
*/
$(function(){
	$("#msform").validate({
					rules: {
						username: "required",
						email:{
							required:true,
							email:true
						},
						fullName:"required",
						password:{
							required:true,
							minlength:6
						},
						cpassword:{
							required:true,
							equalTo:"#password"
						},
					},
					messages: {
						username: "Vui lòng nhập họ và tên",
						email:{
							required:"Vui lòng nhập email",
							email:"Nhập đúng định dạng email"
						},
						fullName:"Vui lòng nhập username",
						password:{
							required:"Vui lòng nhập password",
							minlength:"Mật khẩu phải có 6 kí tự trở lên"
						},
						cpassword:{
							required:"Vui lòng nhập lại mật khẩu",
							equalTo:"Phải nhập đúng mật khẩu đã nhập",
						},
						sodienthoai:{
							required:"Vui lòng nhập số điện thoại",
							digits:"Nhập đúng số điện thoại"
						},
						
					}
				});
	});