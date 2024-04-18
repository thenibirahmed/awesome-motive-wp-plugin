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

    const [tableData, setTableData] = useState();

    useEffect(() => {
        fetchTableData();
    }, []);

    function getTableTitle() {
        return JSON.parse(tableData.data).title;
    }

    function getHeaders() {
        return JSON.parse(tableData.data).data.headers;
    }

    function getTableBody() {
        return JSON.parse(tableData.data).data.rows;
    }

    function fetchTableData() {
        jQuery.ajax({
            url: am_data.ajax_url,
            data: {
                action: 'am_get_table_data',
                nonce: am_data.nonce,
            },
            type: 'GET',
            success: function(response) {
                console.log(JSON.parse(response.data).data.rows);
                if(response.success){
                    setTableData(response);
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }

    if(!tableData){
        return;
    }

    return (
        <div className="awesome-motive-table-block">
            <h4>{ getTableTitle() }</h4>  

            <table>
                <tr>
                    {getHeaders().map((header) => (
                        <th>{header}</th>
                    ))}
                </tr>
                { Object.values(getTableBody()).map((row) => (
                    <tr>
                        { Object.values(row).map((column) => (
                            <td>{column}</td>
                        ))}
                    </tr>
                ))}
            </table>
        </div>
    );
}