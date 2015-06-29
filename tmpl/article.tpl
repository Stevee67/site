<div class="article">
    <h1>%title%</h1>
    %image%
    <p style="float: right;">
        <span>%date%</span>
    </p>
    %full_text%
    <div class="comments">
        <h2>%commare%</h2>
        %comments%
    </div>
    <div id="comment_form">
        <h2>Залишити коментар</h2>
        <p>%meessage%</p>
        <form action="functions.php" method="post">
            <table>
                <tr>
                    <td>
                        <input hidden="true" name="id" value="%id%">
                    </td>
                </tr>
                <tr>
                    <td>
                        <textarea cols="86" rows="10" name="comment"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="comm" value="Відправити">
                    </td>
                </tr>
            </table>
        </form>
    </div>

</div>