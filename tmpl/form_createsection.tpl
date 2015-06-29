<h1>Створення розділу</h1>
%message%
<div class="createsection">
    <form action="functions.php" name="createsection" method="post">
        <table>
            <tr>
                <td><input type="text" name="newid"</td>
                <td>ID</td>
            </tr>
            <tr>
                <td><input type="text" name="newtitle" </td>
                <td>ЗАГОЛОВОК</td>
            </tr>
            <tr>
                <td><textarea name="newdescription" rows="10" cols="22"></textarea></td>
                <td>ОПИС</td>
            </tr>
            <tr>
                <td><input type="text" name="newmetadesc"></td>
                <td>КЛЮЧОВІ РЕЧЕННЯ</td>
            </tr>
            <tr>
                <td><input type="text" name="newmetakey"></td>
                <td>КЛЮЧОВІ СЛОВА</td>
            </tr>
            <tr>
                <td><input type="text" name="newimage"></td>
                <td>Назва картинки + розширення</td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="createsection" value="Створити">
                </td>
            </tr>
        </table>
    </form>
</div>