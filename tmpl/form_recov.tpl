<h1>Відновлення паролю</h1>
%message%
<div id="rec" >
    <form name="rec" action="functions.php" method="post">
        <table>
            <tr>
                <td>
                    <input type="hidden" name="hash" value="%recovery_hash%">
                </td>
            </tr>
            <tr>
                <td>Пароль</td>
                <td>
                    <input type="password" name="password1">
                </td>
            </tr>
            <tr>
                <td>Підтвердження паролю</td>
                <td>
                    <input type="password" name="password2">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" name="rec" value="Змінити пароль">
                </td>
            </tr>
        </table>
    </form>
</div>