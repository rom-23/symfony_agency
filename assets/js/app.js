const $ = require('jquery');
import('./main.js');
require('select2');
$('select').select2();
$('#contactButton').click(e => {
    e.preventDefault();
    $('#contactForm').slideDown();
    $('#contactButton').slideUp();
});
