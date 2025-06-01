document.addEventListener('DOMContentLoaded',(main)=>{

const tdata=document.querySelectorAll("#ballot_table tr");
const search=document.getElementById("input-search");
const searchbtn=document.getElementById("search-btn");

let count;
function searching(e)
{
    count=0;
    tdata.forEach(element=>{
        element.style.display="none";
        if(element.innerHTML.toUpperCase().match(e.value.trim().toUpperCase()))
        {
            element.style.display="table-row";
            count++;
			
        }
    })
}
searchbtn.addEventListener("click",(e)=>{
    searching(search);
})
search.addEventListener("keyup",(e)=>{

	if(e.key=="Enter")
	{
			 searching(search);
	}
	if(e.target.value.trim()=="")
	{
		
		tdata.forEach(element=>{
            element.style.display="table-row";
        })
	}
}
);
});