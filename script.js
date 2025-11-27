
document.querySelectorAll('.dropdown-header button').forEach(button => {
    button.addEventListener('click', function(e) {
        e.stopPropagation();
        const container = this.closest('.arena-selection-container, .time-selection-container');
        const list = container.querySelector('.arena-options-list, .time-options-list');
        list.classList.toggle('active');
    });
});

document.addEventListener('click', function() {
    document.querySelectorAll('.arena-options-list, .time-options-list').forEach(list => {
        list.classList.remove('active');
    });
});

document.addEventListener('click', function(e) {
    if (e.target.classList.contains('arena-option') || e.target.classList.contains('time-option')) {
        const container = e.target.closest('.arena-selection-container, .time-selection-container');
        const btn = container.querySelector('.dropdown-header button');
        btn.innerHTML = e.target.textContent + ' <span class="arrow-icon">▼</span>';

        container.querySelectorAll('.arena-option, .time-option').forEach(o => o.classList.remove('selected'));
        e.target.classList.add('selected');
    }
});

const datePicker = document.getElementById("data-reserva");
datePicker.addEventListener("change", () => {
    console.log("Data selecionada:", datePicker.value);
});


const lista = document.getElementById("lista-horarios");

for (let h = 9; h <= 23; h++) {
    for (let m = 0; m < 60; m += 30) {

        if (h === 23 && m > 0) continue;

        const btn = document.createElement("button");
        btn.classList.add("time-option");

        if (h === 9 && m === 0) btn.classList.add("selected");

        btn.textContent =
            `${String(h).padStart(2,"0")}:${String(m).padStart(2,"0")}`;

        lista.appendChild(btn);
    }
}

