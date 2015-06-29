<h1>Створення статті</h1>


<div class="createarticle">
    <h3>В описі і тексті статті використовуйте HTML теги</h3>
    %message%
    <form action="functions.php" name="createarticle" method="post">
        <table>
            <tr>
                <td><input type="text" name="id" value="%id%"></td>
                <td>ID</td>
            </tr>
            <tr>
                <td><input type="text" name="section_id" value="%section_id%"></td>
                <td>ID розділу</td>
            </tr>
            <tr>
                <td><input type="text" name="title" value="%title%"></td>
                <td>ЗАГОЛОВОК</td>
            </tr>
            <tr>
                <td><textarea name="intro_text" rows="5" cols="70">%intro_text%</textarea></td>
                <td>ОПИС</td>
            </tr>
            <tr>
                <td><textarea name="full_text" rows="10" cols="70">%full_text%</textarea></td>
                <td>ТЕКСТ СТАТТІ</td>
            </tr>
            <tr>
                <td><input type="text" name="metadesc" value="%metadesc%"></td>
                <td>КЛЮЧОВІ ФРАЗИ</td>
            </tr>
            <tr>
                <td><input type="text" name="metakey" value="%metakey%"></td>
                <td>КЛЮЧОВІ СЛОВА</td>
            </tr>
            <tr>
                <td><input type="text" name="image"></td>
                <td>Назва картинки + розширення</td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" name="createarticle" value="Створити">
                </td>
            </tr>
        </table>
    </form>
</div>