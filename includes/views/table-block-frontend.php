<div class="awesome-motive-table-block">
    <h4><?php echo esc_html($title) ?></h4>
    <table>
        <thead>
            <tr>
                <?php foreach( $headers as $header ): ?>
                    <?php echo !in_array($header, $hidden_columns) ? "<th>". esc_html($header) ."</th>" : "" ?>
                <?php endforeach ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach( $rows as $row ) : ?>
                <tr>
                    <?php 
                    $i = 0;
                    foreach( $row as $cell ) : ?>
                        <?php 
                            echo !in_array($headers[$i], $hidden_columns) ? "<td>". esc_html($cell) ."</td>" : "";
                            $i++;
                        ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>