function slideToggle(t,e,o){0===t.clientHeight?j(t,e,o,!0):j(t,e,o)}
function slideUp(t,e,o){j(t,e,o)}
function slideDown(t,e,o){j(t,e,o,!0)}
function j(t,e,o,i){
    void 0===e&&(e=400),void 0===i&&(i=!1),t.style.overflow="hidden",i&&(t.style.display="block");
    var p,l=window.getComputedStyle(t),n=parseFloat(l.getPropertyValue("height")),a=parseFloat(l.getPropertyValue("padding-top")),s=parseFloat(l.getPropertyValue("padding-bottom")),r=parseFloat(l.getPropertyValue("margin-top")),d=parseFloat(l.getPropertyValue("margin-bottom")),g=n/e,y=a/e,m=s/e,u=r/e,h=d/e;
    window.requestAnimationFrame(function l(x){
        void 0===p&&(p=x);var f=x-p;
        i?(t.style.height=g*f+"px",t.style.paddingTop=y*f+"px",t.style.paddingBottom=m*f+"px",t.style.marginTop=u*f+"px",t.style.marginBottom=h*f+"px")
        :(t.style.height=n-g*f+"px",t.style.paddingTop=a-y*f+"px",t.style.paddingBottom=s-m*f+"px",t.style.marginTop=r-u*f+"px",t.style.marginBottom=d-h*f+"px"),
        f>=e?(t.style.height="",t.style.paddingTop="",t.style.paddingBottom="",t.style.marginTop="",t.style.marginBottom="",t.style.overflow="",i||(t.style.display="none"),"function"==typeof o&&o()):window.requestAnimationFrame(l)
    })
}

// Sidebar submenu toggle
let sidebarItems = document.querySelectorAll('.sidebar-item.has-sub');
for(var i = 0; i < sidebarItems.length; i++) {
    let sidebarItem = sidebarItems[i];
    let sidebarLink = sidebarItem.querySelector('.sidebar-link');
    let submenu = sidebarItem.querySelector('.submenu');
    if (sidebarLink && submenu) {
        sidebarLink.addEventListener('click', function(e) {
            e.preventDefault();
            if(submenu.classList.contains('active')) submenu.style.display = "block";
            if(submenu.style.display == "none") submenu.classList.add('active');
            else submenu.classList.remove('active');
            slideToggle(submenu, 300);
        });
    }
}

// Sidebar responsive toggle
window.addEventListener('DOMContentLoaded', (event) => {
    var w = window.innerWidth;
    let sidebar = document.getElementById('sidebar');
    if(sidebar && w < 1200) {
        sidebar.classList.remove('active');
    }
});
window.addEventListener('resize', (event) => {
    var w = window.innerWidth;
    let sidebar = document.getElementById('sidebar');
    if(sidebar) {
        if(w < 1200) {
            sidebar.classList.remove('active');
        }else{
            sidebar.classList.add('active');
        }
    }
});

// Burger button toggle
let burgerBtn = document.querySelector('.burger-btn');
if (burgerBtn) {
    burgerBtn.addEventListener('click', () => {
        let sidebar = document.getElementById('sidebar');
        if(sidebar) sidebar.classList.toggle('active');
    });
}

// Sidebar hide button
let sidebarHide = document.querySelector('.sidebar-hide');
if (sidebarHide) {
    sidebarHide.addEventListener('click', () => {
        let sidebar = document.getElementById('sidebar');
        if(sidebar) sidebar.classList.toggle('active');
    });
}

// Perfect Scrollbar Init
if(typeof PerfectScrollbar == 'function') {
    const container = document.querySelector(".sidebar-wrapper");
    if (container) {
        const ps = new PerfectScrollbar(container, {
            wheelPropagation: false
        });
    }
}

// Scroll into active sidebar
let activeSidebarItem = document.querySelector('.sidebar-item.active');
if (activeSidebarItem) {
    activeSidebarItem.scrollIntoView(false);
}