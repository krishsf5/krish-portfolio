/* --------------------------------------------------
   TECH STACK PARALLAX
-------------------------------------------------- */

export default function initTechParallax(){

    const columns=document.querySelectorAll(".tech-column")

    window.addEventListener("scroll",()=>{

        const scrollY=window.scrollY

        columns.forEach((col,index)=>{

            const speed=(index+1)*0.05

            col.style.transform=`translateY(${scrollY*speed*0.2}px)`

        })

    })

}
