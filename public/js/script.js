const $button  = document.querySelector('#sidebar-toggle');
const $wrapper = document.querySelector('#wrapper');

$button.addEventListener('click', (e) => {
    e.preventDefault();
    $wrapper.classList.toggle('toggled');
});

const nav = document.querySelectorAll('#sidebar-nav > li > a');

/*for (var i = 0; i < nav.length; i++) {
    if (nav[i].nodeType === 1) {
        //console.error(nav[i].getAttribute('href'))
        nav[i].classList.add('active')
        if (nav[i].getAttribute('href') == window.location.href)
        {
            console.error(window.location.href)
        }
    }
}*/

/*$("#sidebar-nav > li > a")[1].click(function(){
    $("#sidebar-nav > li > a")[1].removeClass("working");
    $(this).addClass("working");
    localStorage.ClassName = "working";
});

$(document).ready(function() {
    SetClass();
});

function SetClass() {
//before assigning class check local storage if it has any value
    $("#sidebar-nav > li > a")[1].addClass(localStorage.ClassName);
}*/