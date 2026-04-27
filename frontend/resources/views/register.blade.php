<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>

<h2>Register</h2>

<form id="registerForm">
    <input name="name" placeholder="Name" /><br><br>
    <input name="email" placeholder="Email" /><br><br>
    <input name="password" type="password" placeholder="Password" /><br><br>

    <select name="role">
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
    </select><br><br>

    <button type="submit">Register</button>
</form>

<script>
document.getElementById("registerForm").onsubmit = async (e) => {
    e.preventDefault();

    const form = new FormData(e.target);

    try {
        await axios.post("http://127.0.0.1:8000/api/register", {
            name: form.get("name"),
            email: form.get("email"),
            password: form.get("password"),
            role: form.get("role")
        });

        alert("Registered!");
    } catch (error) {
        console.error(error);
        alert("Error registering");
    }
};
</script>

</body>
</html>