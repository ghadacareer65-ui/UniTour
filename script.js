function calculateWeighted() {

let school = document.getElementById("school").value;
let qudrat = document.getElementById("qudrat").value;
let tahsili = document.getElementById("tahsili").value;

if(school && qudrat && tahsili){

let weighted =
(school * 0.30) +
(qudrat * 0.30) +
(tahsili * 0.40);

document.getElementById("weighted").value = weighted.toFixed(2);

}

}

document.getElementById("school").addEventListener("input",calculateWeighted);
document.getElementById("qudrat").addEventListener("input",calculateWeighted);
document.getElementById("tahsili").addEventListener("input",calculateWeighted);