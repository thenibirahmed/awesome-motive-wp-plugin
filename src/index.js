import './index.scss';

import { PanelBody, PanelRow, CheckboxControl} from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';

const { useState, useEffect } = wp.element;

wp.blocks.registerBlockType( 'awesome-motive/table-block', {
    title: 'AM Table Block',
    icon: 'smiley',
    category: 'common',
    attributes: {
        tableHeaders: {type: 'object'},
        hiddenColumns: {type: 'array', default: []},
    },
    edit: AwesomeMotiveTableBlock,
} );

function AwesomeMotiveTableBlock(props) {

    const [tableData, setTableData] = useState();
    // const [hiddenColumns, setHiddenColumns] = useState([]);

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

    function fetchTableData() {
        try {
            jQuery.ajax({
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
                    console.error(error);
                }
            });
        }catch(error){
            console.error('Error fetching table data');
        }
    }

    function setHiddenColumns(hiddenColumns) {
        props.setAttributes({hiddenColumns});
    }

    if( !tableData ){
        return <p>Loading...</p>;
    }

    return (
        <div className="awesome-motive-table-block">
            <InspectorControls>
                <PanelBody title="Hide Columns">
                    {getHeaders().map((header) => (
                        <PanelRow key={header}>
                            <CheckboxControl
                                label={header}
                                checked={ props.attributes.hiddenColumns.includes(header) }
                                onChange={ (hidden) => {
                                    if(hidden){
                                        setHiddenColumns([...props.attributes.hiddenColumns, header]);
                                    }else{
                                        setHiddenColumns(props.attributes.hiddenColumns.filter((column) => column !== header));
                                    }
                                }}
                            />
                        </PanelRow>
                    ))}
                </PanelBody>
            </InspectorControls>
            <h4>{ getTableTitle() }</h4>  

            <table>
                <tr>
                    {getHeaders().map((header) => (
                        !props.attributes.hiddenColumns.includes(header) &&
                        <th>{header}</th>
                    ))}
                </tr>
                {Object.values(getTableBody()).map((row, rowIndex) => (
                    <tr key={rowIndex}>
                        {Object.values(row).map((column, columnIndex) => (
                            !props.attributes.hiddenColumns.includes(getHeaders()[columnIndex]) &&
                            <td key={columnIndex}>{column}</td>
                        ))}
                    </tr>
                ))}
            </table>
        </div>
    );
}