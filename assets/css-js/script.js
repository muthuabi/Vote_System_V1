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
    })
    
})
window.history.replaceState(null,null,window.location.href);
/*
Vote System Project for St. Xavier's College
Developed By Muthukrishnan M
Started 10 Days Before the 2024-25 Academic Year Election.
*/