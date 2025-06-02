let maincanvas;
window.addEventListener("resize",(e)=>{
  

    if(maincanvas)
    {
       if(window.innerWidth>=768)
       {
           //maincanvas.style.transform='translateX(0)';
           maincanvas.style.visibility='visible';
           document.querySelectorAll('.modal-backdrop').forEach(element=>{
            element.style.display='none';
           })   
        //    maincanvas.setAttribute('visibility','visible');
       }
       else
       { 
           maincanvas.style.visibility='hidden';
       }
    }
       
})
// function print_doc(id='')
// {
//     if(!id)
//     {
//         document.querySelectorAll(`#ballot_all tr:has(#vote_status[class='down_vote'])`).forEach(element=>{
//             element.style.display='none';
//         })
//     }
//     else
//     {
//         document.body.innerHTM=document.querySelector(`#${id}`).innerHTML;
      
//     }
//     window.print();
//     location.reload();
// }



const stopAnimations = () => {
    const style = document.createElement('style');
    style.innerHTML = `
        * {
            animation: none !important;
            transition: none !important;
        }
    `;
    style.id = 'stop-animations';
    document.head.appendChild(style);
};

const resumeAnimations = () => {
    const style = document.getElementById('stop-animations');
    if (style) style.remove();
};


//Image Optimization
function initializeLazyImages() {
  var lazyImages = [];
  var placeholder = "data:image/gif;base64,R0lGODlhAQABAPAAACMjIyH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==";

  var allImages = document.querySelectorAll("img");
  for (var i = 0; i < allImages.length; i++) {
    var img = allImages[i];

    // Skip excluded images
    if (img.classList.contains("can_small_image") || img.classList.contains("sxc-header-icon-print")) {
      continue;
    }

    var realSrc = img.src;

    if (realSrc && !img.getAttribute("data-lazy")) {
      var testImg = new Image();
      testImg.src = realSrc;

      if (!testImg.complete) {
        img.setAttribute("data-lazy", realSrc);
        img.src = placeholder;
        img.classList.add("lazy-blur");
        lazyImages.push(img);
      }
    }
  }

  var observer = new IntersectionObserver(function(entries, obs) {
    for (var i = 0; i < entries.length; i++) {
      var entry = entries[i];

      if (entry.isIntersecting) {
        var img = entry.target;
        var realSrc = img.getAttribute("data-lazy");
        if (!realSrc) continue;

        var temp = new Image();
        temp.src = realSrc;

        temp.onload = function() {
          img.src = realSrc;
          img.removeAttribute("data-lazy");
          img.classList.remove("lazy-blur");
          obs.unobserve(img);
        };
      }
    }
  }, {
    rootMargin: "100px 0px",
    threshold: 0.01
  });

  for (var j = 0; j < lazyImages.length; j++) {
    observer.observe(lazyImages[j]);
  }
}

document.addEventListener("DOMContentLoaded", function() {
  initializeLazyImages();
});

document.addEventListener("DOMContentLoaded",(event)=>{

    
    const password_types=document.querySelectorAll("input[type='password']");
    password_types.forEach(element=>{
        const password_show=document.createElement("input");
        password_show.type='checkbox';
        password_show.className='password-show';
        element.insertAdjacentElement('afterend',password_show);
        password_show.addEventListener("change",(e)=>{
            if(e.target.checked)
                e.target.previousElementSibling.type='text';
            else
                e.target.previousElementSibling.type='password';
                
        })
    })
    const date=new Date();
    maincanvas=document.querySelector("#maincanvas");
    const academic_year=date.getFullYear()+'-'+((date.getFullYear()+1)%100);
    const sxc_footer_head=`Designed & Maintained by SXC ERP and Web Team | © 2024 St. Xavier's College. All rights reserved`;
    const sxc_heading='Students Council Election '+academic_year;
    const on_off=document.getElementById('on_off');
    const liveblink=document.getElementById('live-blink');
    const votestatus=document.getElementById('vote_status');
    const footerhead=document.querySelector('.footer-head b');
    const sxcheader=document.querySelector('.sxc-council-header h5 ');
    const ballothead=document.querySelector('#ballot_head b');
    const tab_title=document.querySelector('head title');
    let tab_icon=document.querySelector(`link[rel="shortcut icon"]`);
    const head=document.querySelector('head');
    // if(window.location.href.match("http://localhost/Vote_System/user/") )
    // {
        if(document.querySelector("title"))
            document.querySelector("title").innerHTML=sxc_heading;
    // }
    if(head)
    {
        head.innerHTML+=`
        <meta name="author" content="Muthukrishnan M" />
        <meta name="acknowledgement" content="This Vote System Project is developed by Muthukrishnan M. Special thanks 
        to all the faculty of SXC ERP and Web Team for their support in the development." />
        <meta name="developer" content="Muthukrishnan M" />
        `;
    }
    if(!tab_icon)
    {
        if(head)
        {
           head.innerHTML+=`<link rel='shortcut icon' href='http://localhost/Vote_System/assets/images/other_images/logo2.png' type='image/x-icon' /> `;
        }
    }
    if(tab_title)
        tab_title.innerHTML=sxc_heading;
    if(footerhead)
    footerhead.innerHTML=sxc_footer_head;
	if(sxcheader)
    sxcheader.innerHTML=sxc_heading;
    if(ballothead)
    ballothead.innerHTML=sxc_heading; 
    function init_toast(message = "", id = "my_toast_offline") {
    const toast = document.querySelector(`.toast#${id}`);
    if(toast)
    {
        if (message)
          document.querySelector(`#${id} #message`).innerText = message;
        toaster = new bootstrap.Toast(toast);
        toaster.show();
    }
  }
    window.addEventListener("server-online",(e)=>{
        if(liveblink)
        liveblink.getAnimations()[0].play();
        // votestatus.getAnimations()[0].play();

		init_toast('Server Back Online');
        // init_toast('Connection Back Online',"my_toast_offline_user");
    });
    window.addEventListener("server-offline",(e)=>{
		if(liveblink)
        liveblink.getAnimations()[0].pause();
		// votestatus.getAnimations()[0].pause();
        init_toast('Server Offline');
        // init_toast('Connection Offline',"my_toast_offline_user");
    });
    window.addEventListener("online",(e)=>{
        if(on_off)
        on_off.innerHTML=`<small style='background-color:green;border-radius:50%;width:10px;height:10px;'></small><small>Online</small>`;
        if(liveblink)
        liveblink.getAnimations()[0].play();
        // votestatus.getAnimations()[0].play();
		init_toast('Connection Back Online');
        // init_toast('Connection Back Online',"my_toast_offline_user");
	})
    window.addEventListener("offline",(e)=>{
        if(on_off)
        on_off.innerHTML=`<small style='background-color:red;border-radius:50%;width:10px;height:10px;'></small><small>Offline</small>`;
		if(liveblink)
        liveblink.getAnimations()[0].pause();
		// votestatus.getAnimations()[0].pause();
        init_toast('Connection Offline');
        // init_toast('Connection Offline',"my_toast_offline_user");
	})
    // const elems=document.querySelectorAll(".content-wrapper,.main-card-container");
    const elems=document.querySelectorAll(".content-wrapper");
    function enablefullscreen(elem)
    {
        if(document.fullscreenElement)
        {
            if(document.exitFullscreen)
            {
                document.exitFullscreen();
                //localStorage.setItem("isFullscreen","false");
            }
        }
        else
        {   
            if(elem.requestFullscreen)
            {
                elem.requestFullscreen();
                elem.style.backgroundColor='white';
                elem.style.color='black';
                //localStorage.setItem("isFullscreen","true");
            }
        }
    }
    elems.forEach(element=>{

        // console.log(element);
        element.addEventListener("dblclick",(e)=>{
            // console.log(e.target.className,e.target.id);
            if(e.target.className==element.className || e.target.id=='common_post')
                enablefullscreen(element)
        });
    });   
    function fullScreenConstraint() {
          // Avoid duplicates
          if (document.fullscreenElement) return;
          if (document.getElementById('fullscreen-overlay')) return;

          // Create overlay
          const overlay = document.createElement('div');
          overlay.id = 'fullscreen-overlay';
          overlay.style.position = 'fixed';
          overlay.style.top = 0;
          overlay.style.left = 0;
          overlay.style.width = '100vw';
          overlay.style.height = '100vh';
          overlay.style.background = 'rgba(0, 0, 0, 0.85)';
          overlay.style.color = '#fff';
          overlay.style.display = 'flex';
          overlay.style.flexDirection = 'column';
          overlay.style.justifyContent = 'center';
          overlay.style.alignItems = 'center';
          overlay.style.zIndex = 9999;

          // Message
          const msg = document.createElement('p');
          msg.textContent = 'You must continue in fullscreen mode.';
          msg.style.fontSize = '1.5rem';
          msg.style.marginBottom = '20px';

          // Button
          const btn = document.createElement('button');
          btn.textContent = 'Continue';
          btn.style.padding = '10px 20px';
          btn.style.fontSize = '1rem';
          btn.style.cursor = 'pointer';

          btn.onclick = async () => {
            try {
              await document.documentElement.requestFullscreen();
              overlay.remove();
            } catch (err) {
              alert('Failed to enter fullscreen. Please try again.');
              console.error(err);
            }
          };

          overlay.appendChild(msg);
          overlay.appendChild(btn);
          document.body.appendChild(overlay);
    }

    // document.addEventListener('fullscreenchange', () => {
    //       if (!document.fullscreenElement) {
    //         if(location.pathname.includes("/user/"))
    //             fullScreenConstraint();
    //       }
    // });

});
window.history.replaceState(null,null,window.location.href);
/*
Vote System Project for St. Xavier's College
Developed By Muthukrishnan M
Started 10 Days Before the 2024-25 Academic Year Election.
*/
