// clone of function from 0.js. If picked from 0.js when dont work. Why? Server update time?
// just use this file for now
function zero_controls_close_reverRedirt() {
	console.log('TRO FUNC HELLO');
	document.querySelector(".zero_popup").classList.add("out")
	document.querySelector(".zero_popup").classList.remove("two")

	mainsite = window.location.host
	prid = document.querySelector("#current_project_id").value

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
		window.location.replace("http://" + mainsite + "/post.php?id=" + prid + "&user=" + selected_user)
	} else if (loggined_usr == 'noUser'){
        document.location.href = "http://" + mainsite + "/revRedir/sessionFromGet.php?id=" + prid + "&user=" + selected_user;
	} else {
		document.location.href = "http://" + mainsite + "/logout.php";
	}
}