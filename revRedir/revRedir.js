// clone of function from 0.js. If picked from 0.js when dont work. Why? Server update time?
// just use this file for now
function zero_controls_close_reverRedirt() {
	document.querySelector(".zero_popup").classList.add("out")
	document.querySelector(".zero_popup").classList.remove("two")

	mainsite = window.location.host
	prid = document.querySelector("#current_project_id").value
    project_type = document.querySelector("#current_project_measurement").value;

	if (document.querySelector("#usr__selection").value.charAt(0) == " ") {
		selected_user = document
			.querySelector("#usr__selection")
			.value.replace(" ", "")
	} else {
		selected_user = document.querySelector("#usr__selection").value
	}
	console.log(selected_user);
	let loggined_usr = document.querySelector("#loggined_usr").value
	console.log(loggined_usr);
	if (loggined_usr == selected_user){
        if (project_type=='Julkisivu'){
            window.location.replace("http://julkisivut2.gromi.fi/post.php?id=" + prid + "&user=" + selected_user)
        } else {
            window.location.replace("http://" + mainsite + "/post.php?id=" + prid + "&user=" + selected_user)
        }
        //редирект на домен фасадов или на текущий (если авторизован в обоих случаях)
	} else if (loggined_usr == 'noUser'){
        document.location.href = "http://" + mainsite + "/revRedir/sessionFromGet.php?id=" + prid + "&user=" + selected_user;
	} else {
		document.location.href = "http://" + mainsite + "/logout.php";
	}
}