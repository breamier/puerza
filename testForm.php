<!DOCTYPE html>
<html>
<head>

</head>
<body>
    <form action="generateWorkout.php" method="get">
            <table>
                <tr>
                    <td colspan="2">What would you like to do today?</td>
                </tr>
                <tr>
                    <label for="date">Select a Date:</label>
                    <input type="date" id="date" name="date">
                </tr>
                <tr>
                    <td>
                        <div>
                            <h3 class="label">Strength Training</h3>
                            <br>
                            <input type="radio" name="type" value="1">Deadlift Set<br>
                            <input type="radio" name="type" value="2">Backsquat Set<br>
                        </div>
                    </td>
                    <td>
                        <div>
                            <h3 class="label">Plyometrics</h3>
                            <br>
                            <div style="column-count: 2;">
                                <input type="radio" name="type" value="3">Beginner Set<br>
                                <input type="radio" name="type" value="4">Intermediate Set<br>
                                <input type="radio" name="type" value="5">Extreme Set<br>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Enter your IRPM:</td>
                </tr>
                <tr>
                    <td>Deadlift:</td>
                    <td><input type="number" name="drpm"></td>
                    <td>Chest Press:</td>
                    <td><input type="number" name="crpm"></td>
                </tr>
                <tr>
                    <td>Shoulder Press:</td>
                    <td><input type="number" name="srpm"></td>
                    <td>Backrow:</td>
                    <td><input type="number" name="brpm"></td>
                </tr>
                <tr>
                    <td>Back Squat: </td>
                    <td><input type="number" name="bsrpm"></td>
                </tr>
                <tr>
                    <td>
                        Lifting Percentage:<br>
                        <input type="radio" name="lp" value="75">75%<br>
                        <input type="radio" name="lp" value="80">80%<br>
                        <input type="radio" name="lp" value="85">85%<br>
                        <input type="radio" name="lp" value="90">90%<br>
                        <input type="radio" name="lp" value="95">95%<br>
                        <input type="radio" name="lp" value="100">100%<br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Which isolation exercises would you like to do?</td>
                    <td>
                        <input type="radio" name="iso" value="1">Biceps and Triceps<br>
                        <input type="radio" name="iso" value="2">Shoulders<br>
                        <input type="radio" name="iso" value="3">Abs, Core, Side Obliques<br>
                        <input type="radio" name="iso" value="4">Calves<br>
                        <input type="radio" name="iso" value="5">Maybe Next Time<br>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" value="Generate Workout" class="submit-button"></td>
                </tr>
            </table>
            
        </form>
</body>
</html>