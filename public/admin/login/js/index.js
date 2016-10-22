// Toggle Function
$('.toggle').click(function(){
  // Switches the Icon
  $(this).children('i').toggleClass('fa-arrow-right');
  if ($(this).children('.tooltiptext').text() == 'Quên mật khẩu') {
  	$(this).children('.tooltiptext').text('Về đăng nhập');
  } else {
  	$(this).children('.tooltiptext').text('Quên mật khẩu');
  }
  // Switches the forms  
  $('.form').animate({
    height: "toggle",
    'padding-top': 'toggle',
    'padding-bottom': 'toggle',
    opacity: "toggle"
  }, "slow");
});

$("div.alert").delay(3000).slideUp();