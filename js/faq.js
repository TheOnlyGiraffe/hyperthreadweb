const faqs = document.querySelectorAll(".faq-block");


let rect;
let height1;

faqs.forEach(faq => {
    faq.addEventListener("click", () => {
        faq.classList.toggle("faq-active");
        height1 = faq.scrollHeight;
        
        if(faq.classList.contains("faq-active")) {
            faq.style.height = `${height1}px`;
        } else {
            faq.style.height = "3rem";
        }
    });
});

