var tournaments;
var filteredTournaments;
var noAdmin;

const debounce = (callback) => {
  let timer;
  return (params) => {
    clearTimeout(timer);
    timer = setTimeout(() => callback(params), 500);
  };
};

const clearList = () => {
  const container = document.getElementById("tournaments");
  container.innerHTML = "";
};

const debouncedSearch = debounce(function (e) {
  const inputText = e.target.value; // Get the text typed by user
  filteredTournaments = tournaments.filter(({ name }) =>
    name.toLowerCase().includes(inputText.toLowerCase())
  );
  clearList();
  initTournaments(filteredTournaments);
});

const initSearch = () => {
  const search = document.getElementById("search");
  if (search) {
    search.addEventListener("keyup", debouncedSearch);
  }
};

const close = () => {
  const sideMenu = document.getElementById("side-menu");
  sideMenu.classList.remove("menu-open");
  const enableClose = document.getElementsByClassName("menu-bg")[0];
  enableClose.classList.remove("open");
  enableClose.removeEventListener("click", close);
};

const open = () => {
  const sideMenu = document.getElementById("side-menu");
  sideMenu.classList.add("menu-open");
  const enableClose = document.getElementsByClassName("menu-bg")[0];
  enableClose.classList.add("open");
  enableClose.addEventListener("click", close);
};

const initHamburger = () => {
  const hamburger = document.getElementById("hamburger");
  if (hamburger) {
    hamburger.addEventListener("click", open);
  }
};

/* create dynamic cards of tournamnets */
const chunk_size = 3;

function chunkArray(arr = [], chunk_size = 3) {
  var index = 0;
  var arrayLength = arr.length;
  var tempArray = [];
  for (index = 0; index < arrayLength; index += chunk_size) {
    myChunk = arr.slice(index, index + chunk_size);
    tempArray.push(myChunk);
  }
  return tempArray;
}

const initTournaments = (tournaments) => {
  const rows = chunkArray(tournaments, chunk_size);
  rows.forEach((row) => {
    const container = document.getElementById("tournaments");
    const rowElement = document.createElement("div");
    rowElement.classList.add("row", "mb-2");
    row.forEach((column) => {
      console.log({ column });
      const columnElement = document.createElement("div");
      columnElement.classList.add('"col-md-6', "col-lg-4", "mb-3");
      columnElement.innerHTML = `
      <div class="modal fade show d-none" id="deleteModal-${column.tournament_num}" tabindex="-1" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel2">Warning!<br>Are you sure you want to delete ${column.name} tournament?</h5>
            <button type="button" class="btn-close" onclick="backHome()" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
          </div>
          <div class="modal-footer">
            <button type="button" id="cancel" class="btn btn-outline-secondary" data-bs-dismiss="modal" onclick="backHome()">Cancel</button>
            <button type="button" id="warning" class="btn btn-primary" onclick="deleteTour(${column.tournament_num})">Delete</button>
          </div>
        </div>
      </div>
    </div>
      <div class="card ${column.gender} ${column.tennis_center} ${column.category}" onclick="window.location.href='http://localhost/CheckwithRacheli/tournement.php?tid=${column.tournament_num}'">
      <div class="card-header">
      <span>${column.name}</span>
      <div>
          <i class="small_menu fa-solid fa-ellipsis-vertical"></i>
          <ul class="more-info-menu d-none">
          <li onclick="go_to_edit(${column.tournament_num})">edit</li>
          <li data-bs-toggle="modal" data-bs-target="#deleteModal-${column.tournament_num}" onclick="open_modal(${column.tournament_num})">delete</li>
          </ul>
          </div>
      </div>
      <div class="card-body">
          <div class="progress">
              <div class="progress-bar bg-success" role="progressbar" style="width: ${column.status}%"
                  aria-valuenow="${column.status}" aria-valuemin="0" aria-valuemax="100">${column.status}%</div>
          </div>
          <div class="card-meta">
              <div class="tournament-attribute"><i
                      class="fa-solid fa-xl fa-people-group"></i><span>${column.participants_num}</span>
              </div>
              <div class="tournament-attribute date"><i
                      class="fa-solid fa-xl fa-calendar"></i><span>${column.date}</span>
              </div>
              <div class="tournament-attribute"><i
                      class="fa-solid fa-xl fa-table-cells"></i><span>${column.age}</span>
              </div>

          </div>
      </div>
  </div>`;
      rowElement.appendChild(columnElement);
    });
    container.appendChild(rowElement);
  });
  removeManu(noAdmin);
};

initHamburger();
initTournaments(tournaments);
initSearch();

const createBtn = document.getElementsByClassName("createBtn");
for (const btn of createBtn) {
  btn.addEventListener("click", function () {
    window.location.href = "http://localhost/CheckwithRacheli/create.php";
  });
}

/* get tennis centers from json */
function showcenter(data) {
  const input_center = document.getElementById("center");
  if (!input_center) {
    return;
  }
  for (const key in data.Tennis_centers) {
    const { name, id } = data.Tennis_centers[key];
    input_center.innerHTML += `<option value="${id}" id="${id}">${name}</option>`;
  }
}

function showCenterFilter(data) {
  const input_center = document.getElementById("centerFilter");
  if (!input_center) {
    return;
  }
  for (const key in data.Tennis_centers) {
    const { name, id } = data.Tennis_centers[key];
    input_center.innerHTML += `<button class="dropdown-item filterBth" onclick="filterSelection('${id}')">${name}</button>`;
  }
}

fetch("http://localhost/CheckwithRacheli/tennis_centers.json")
  .then((response) => response.json())
  .then((data) => showcenter(data));

fetch("http://localhost/CheckwithRacheli/tennis_centers.json")
  .then((response) => response.json())
  .then((data) => showCenterFilter(data));

window.onload = () => {
  const more_menu = document.getElementsByClassName("small_menu");
  for (const menu of more_menu) {
    menu.addEventListener("mouseenter", small_menu_func);
    const small_menu = menu.parentElement.getElementsByTagName("ul")[0];
    small_menu.addEventListener("mouseleave", small_menu_func_out);
  }
};

function small_menu_func() {
  const small_menu = this.parentElement.getElementsByTagName("ul")[0];
  if (small_menu.classList.contains("d-none")) {
    small_menu.classList.remove("d-none");
    small_menu.classList.add("d-block");
  }
}

function small_menu_func_out() {
  this.classList.remove("d-block");
  this.classList.add("d-none");
}

function open_modal(tid) {
  const e = window.event;
  e.cancelBubble = true;
  if (e.stopPropagation) e.stopPropagation();
  e.preventDefault();
  smallModal = document.getElementById(`deleteModal-${tid}`);
  smallModal.classList.remove("d-none");
  smallModal.classList.add("d-block");
}

function backHome() {
  window.location.href = "http://localhost/CheckwithRacheli/index.php";
}

function deleteTour(x) {
  console.log({ x });
  window.location.href = `http://localhost/CheckwithRacheli/delete.php?tid=${x}`;
}

function go_to_edit(x) {
  const e = window.event;
  e.cancelBubble = true;
  if (e.stopPropagation) e.stopPropagation();
  e.preventDefault();
  window.location.href = `http://localhost/CheckwithRacheli/edit.php?tid=${x}`;
}

function setRegistration(dateTournament) {
  let Registration = document.getElementById("Registration");
  let RegistrationTempDate = new Date(dateTournament);
  let RegistrationDate = new Date(
    RegistrationTempDate.setDate(
      RegistrationTempDate.getDate(dateTournament) - 30
    )
  )
    .toISOString()
    .slice(0, 10);
  Registration.value = RegistrationDate;
  Registration.removeAttribute("readonly");
  Registration.max = RegistrationDate;
}

const navigateToFormStep = (stepNumber) => {
  let validation, ErrorMessage;
  if (stepNumber == 2) {
    date.min = new Date().toISOString().split("T")[0];
    validation = document.getElementById('tournament-name');
    if (validation.value.length < 3) {
      ErrorMessage = document.getElementById('errorMessageName');
      ErrorMessage.innerHTML = 'The name of the tournament must be at least 3 in length';
      validation.style.background = '#c2eb2d';
      validation.addEventListener('change', () => {
        validation.style.background = 'white';
        ErrorMessage.innerHTML = ''
      });
      return;
    }
  }
  if (stepNumber == 3) {
    validation = document.getElementById('date');
    if (!validation.value) {
      ErrorMessage = document.getElementById('errorMessageDate');
      ErrorMessage.innerHTML = 'Date selection is required';
      validation.style.background = '#c2eb2d';
      validation.addEventListener('change', () => {
        validation.style.background = 'white';
        ErrorMessage.innerHTML = ''
      });
      return;
    }
  }
  document.querySelectorAll(".form-step").forEach((formStepElement) => {
    formStepElement.classList.add("d-none");
  });
  document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
    formStepHeader.classList.add("form-stepper-unfinished");
    formStepHeader.classList.remove(
      "form-stepper-active",
      "form-stepper-completed"
    );
  });

  document.querySelector("#step-" + stepNumber).classList.remove("d-none");

  const formStepCircle = document.querySelector(
    'li[step="' + stepNumber + '"]'
  );

  formStepCircle.classList.remove(
    "form-stepper-unfinished",
    "form-stepper-completed"
  );
  formStepCircle.classList.add("form-stepper-active");
  for (let index = 0; index < stepNumber; index++) {
    const formStepCircle = document.querySelector('li[step="' + index + '"]');
    if (formStepCircle) {
      formStepCircle.classList.remove(
        "form-stepper-unfinished",
        "form-stepper-active"
      );
      formStepCircle.classList.add("form-stepper-completed");
    }
  }
};
document
  .querySelectorAll(".btn-navigate-form-step")
  .forEach((formNavigationBtn) => {
    formNavigationBtn.addEventListener("click", () => {
      const stepNumber = parseInt(
        formNavigationBtn.getAttribute("step_number")
      );
      navigateToFormStep(stepNumber);
    });
  });

  function filterSelection(filterChoice) {
    let i, Result = 0;
    let tournamentsArrTemp = new Array();
    filterResult = document.getElementById('filterResult');
  
    if (filterChoice == 'all') {
      filterResult.style.display = 'none';
      clearList();
      initTournaments(tournaments);
      return
    }
  
    filterResult.style.display = 'block';
    filterResult.onclick = () => {
      filterSelection("all");
    };
  
    for (i = 0; i < tournaments.length; i++) {
      if (filterChoice == tournaments[i].category) {
        tournamentsArrTemp.push(tournaments[i]);
        Result++;
      }
    }
  
    for (i = 0; i < tournaments.length; i++) {
      console.log(filterChoice + ' ' + tournaments[i])
      if (filterChoice == tournaments[i].tennis_center) {
        tournamentsArrTemp.push(tournaments[i]);
        Result++;
      }
    }
  
    for (i = 0; i < tournaments.length; i++) {
      if (filterChoice == tournaments[i].gender) {
        tournamentsArrTemp.push(tournaments[i]);
        Result++;
      }
    }
  
    clearList();
    if (Result != 0) {
      initTournaments(tournamentsArrTemp);
    };
  
    filterChoice = cenetr(filterChoice);
    filterResult.innerHTML = filterChoice + '&nbsp;x' + Result;
  }
  
  // Changing a tennis center from numbers to string
  function cenetr(value) {
    let center, tempValue, num;
  
    tempValue = value;
    num = parseInt(tempValue);
  
    switch (num) {
      case num = 1:
        center = 'Misgav Club'
        break;
      case num = 2:
        center = 'Top Club'
        break;
      case num = 3:
        center = 'Rokah'
        break;
      case num = 4:
        center = 'Court Philippe Chatrier'
        break;
      case num = 5:
        center = 'Wigmore Lawn Tennis Club'
        break;
      case num = 6:
        center = 'South Tennis Center'
        break;
  
      default:
        center = value;
        break;
    }
    return center;
  }
  
  function removeManu(admin) {
    let i;
    let dot = document.getElementsByClassName("smallMenuAdmin");
    if (admin == 1) {
      for (i = 0; i < dot.length; i++) {
        dot[i].style.display = "none";
      }
    }
  }