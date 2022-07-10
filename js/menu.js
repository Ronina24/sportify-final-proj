var tournaments;
var filteredTournaments;

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

function profile_func() {
  let profile_menu = document.getElementById("profile");
  if (profile_menu.classList.contains("d-none")) {
    profile_menu.classList.remove("d-none");
  } else {
    profile_menu.classList.add("d-none");
  }
}
filterSelection("all");
function filterSelection(filterChoice) {
  let filterBy,
    i,
    Result = 0;
  filterBy = document.getElementsByClassName("card");
  filterResult = document.getElementById("filterResult");
  if (filterChoice == "all") {
    filterChoice = "";
    filterResult.style.display = "none";
  } else {
    filterResult.style.display = "block";
    filterResult.onclick = () => {
      filterSelection("all");
    };
  }
  for (i = 0; i < filterBy.length; i++) {
    AddClass(filterBy[i], "d-none");
    if (filterBy[i].className.indexOf(filterChoice) > -1) {
      RemoveClass(filterBy[i], "d-none");
      filterBy[i].style.removeProperty("visibility");
      Result++;
    }
    filterResult.innerHTML = filterChoice + "&nbsp;x" + Result;
  }
}

function AddClass(element, name) {
  let i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    if (arr1.indexOf(arr2[i]) == -1) {
      element.className += " " + arr2[i];
    }
  }
}

function RemoveClass(element, name) {
  var i, arr1, arr2;
  arr1 = element.className.split(" ");
  arr2 = name.split(" ");
  for (i = 0; i < arr2.length; i++) {
    while (arr1.indexOf(arr2[i]) > -1) {
      arr1.splice(arr1.indexOf(arr2[i]), 1);
    }
  }
  element.className = arr1.join(" ");
}
