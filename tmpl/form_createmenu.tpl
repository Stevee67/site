<h1>Створення пункту меню</h1>
%message%
<div id="create" >
    <form name="rec" action="functions.php" method="post">
        <table>
            <tr>
                <td>Назва пункту</td>
                <td>
                    <input type="text" name="title">
                </td>
            </tr>
            <tr>
                <td>ID розділу</td>
                <td>
                    <input type="text" name="id">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="right">
                    <input type="submit" name="create" value="Створити меню">
                </td>
            </tr>
        </table>
    </form>
</div>