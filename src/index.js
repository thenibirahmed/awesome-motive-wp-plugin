import './index.scss';

const { useState, useEffect } = wp.element;

wp.blocks.registerBlockType( 'awesome-motive/table-block', {
    title: 'AM Table Block',
    icon: 'smiley',
    category: 'common',
    attributes: {
        tableHeaders: {type: 'object'},
    },
    edit: AwesomeMotiveTableBlock,
} );

function AwesomeMotiveTableBlock() {

    const [data, setData] = useState({});

    useEffect(() => {
        getTableData();
    }, []);

    function getStatus() {
        return data.success;
    }

    function getTableData() {
        jQuery.ajax({
            url: am_data.ajax_url,
            data: {
                action: 'am_get_table_data',
                nonce: am_data.nonce,
            },
            type: 'GET',
            success: function(response) {
                if(response.success){
                    setData(response);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }


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