import './index.scss';

wp.blocks.registerBlockType( 'awesome-motive/table-block', {
    title: 'AM Table Block',
    icon: 'table',
    category: 'common',
    edit: AwesomeMotiveTableBlock,
    save: AwesomeMotiveTableBlock,
} );

function AwesomeMotiveTableBlock() {
    return (
        <div className="awesome-motive-table-block">
            <h4>Awesome Motive Table Block</h4>  
            <table>
                <tr>
                    <th>Row 1 Column 1</th>
                    <th>Row 1 Column 2</th>
                </tr>
                <tr>
                    <td>Row 2 Column 1</td>
                    <td>Row 2 Column 2</td>
                </tr>
                <tr>
                    <td>Row 3 Column 1</td>
                    <td>Row 3 Column 2</td>
                </tr>
            </table>
        </div>
    );
}