function validateForm() {
  const theme = document.getElementById("theme").value;
  const meetingDate = document.getElementById("meeting_date").value;
  const meetingTime = document.getElementById("meeting_time").value;
  const leader = document.getElementById("leader").value;
  const attendees = document.getElementById("attendees").value;
  const notes = document.getElementById("notes").value;

  if (!theme || theme.length < 3) {
    alert("Tema rapat harus diisi dan minimal 3 karakter.");
    return false;
  }

  if (!meetingDate) {
    alert("Tanggal rapat harus diisi.");
    return false;
  }

  if (!meetingTime) {
    alert("Waktu rapat harus diisi.");
    return false;
  }

  if (!leader || leader.length < 2) {
    alert("Pimpinan rapat harus diisi dan minimal 2 karakter.");
    return false;
  }

  if (!attendees || attendees.split(",").length < 1) {
    alert("Daftar hadir harus diisi dengan minimal 1 nama.");
    return false;
  }

  if (!notes || notes.length < 10) {
    alert("Notulensi harus diisi dan minimal 10 karakter.");
    return false;
  }

  return true;
}

function validateRegisterForm() {
  const username = document.getElementById("username").value;
  const email = document.getElementById("email").value;
  const password = document.getElementById("password").value;
  const department = document.getElementById("department").value;

  if (!username || username.length < 3) {
    alert("Username harus diisi dan minimal 3 karakter.");
    return false;
  }

  if (!email || !email.includes("@")) {
    alert("Email harus valid.");
    return false;
  }

  if (!password || password.length < 6) {
    alert("Password harus diisi dan minimal 6 karakter.");
    return false;
  }

  if (!department) {
    alert("Bidang harus dipilih.");
    return false;
  }

  return true;
}

function validateLoginForm() {
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;

  if (!username) {
    alert("Username harus diisi.");
    return false;
  }

  if (!password) {
    alert("Password harus diisi.");
    return false;
  }

  return true;
}
