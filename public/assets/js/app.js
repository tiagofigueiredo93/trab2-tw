//ANIMAÇÃO DO MENU

//função auto invocada, para não compartilhar de forma global  
(function(){
    //BUSCAR o nome da class css
   const menuToggle = document.querySelector('.menu-toggle');
menuToggle.onclick = function(e) {
   // console.log('Deu!');

   //buscar o body
    const body = document.querySelector('body')
    //Se a class existe ele remove se não adiciona
    body.classList.toggle('hide-sidebar');
    
} 
})()



function activateClock() {
    const activateClock = document.querySelector('[active-clock]');

    if(!activateClock) return

    //adicionar 1 segundo
function addOneSecond(hours, minutes, seconds){
    const d = new Date()
    //definir horas minutos e segundos 
    d.setHours(parseInt(hours))
    d.setMinutes(parseInt(minutes))
    d.setSeconds(parseInt(seconds) + 1)

    //padStart para caso getHours retorne apenas um numero padStart adiciona 2 digitos com um zero á esquerda
    const h = `${d.getHours()}`.padStart(2, 0) 
     //padStart para caso getMinutes retorne apenas um numero padStart adiciona 2 digitos com um zero á esquerda
    const m = `${d.getMinutes()}`.padStart(2, 0)
     //padStart para caso getSeconds retorne apenas um numero padStart adiciona 2 digitos com um zero á esquerda
    const s = `${d.getSeconds()}`.padStart(2, 0)
    return `${h}:${m}:${s}`

}

    //função para a cada segundo pegar o conteudo interno e incrementar 1segundo    
    setInterval(function(){
        //parts vai receber horas minutos e segundos sem ":" visto que split "parte" a string baseado nos " : " 
        const parts = activateClock.innerHTML.split(':')
        activateClock.innerHTML = addOneSecond(parts[0],parts[1],parts[2])
    },1000)

    
}

activateClock()