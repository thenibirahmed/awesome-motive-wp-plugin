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
        return tableData?.title;
    }

    function getHeaders() {
        return tableData?.data.headers;
    }

    function getTableBody() {
        return tableData?.data.rows;
    }

    async function fetchTableData() {

        try {
            await jQuery.ajax({
                url: am_data.ajax_url,
                data: {
                    action: 'am_get_table_data',
                    nonce: am_data.nonce,
                },
                type: 'GET',
                success: function(response) {
                    if(response.success){
                        setTableData(JSON.parse(response.data));
                    }else{
                        console.error('Error fetching table data, Response: ', response);
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }catch(error){
            console.log('Error fetching table data');
        }
    }

    if( !tableData ){
        return <p>Loading...</p>;
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
                { Object.values(getTableBody()).map((row, rowIndex) => (
                    <tr key={rowIndex}>
                        {Object.values(row).map((column, columnIndex) => (
                            <td key={columnIndex}>{column}</td>
                        ))}
                    </tr>
                ))}
            </table>
        </div>
    );
}