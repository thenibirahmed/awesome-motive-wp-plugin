import './index.scss';

import { PanelBody, PanelRow, CheckboxControl} from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';

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

    function getHiddenColumns() {
        return props.attributes.hiddenColumns ?? [];
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
                        console.error( __('Error fetching table data, Response: ', 'awesome-motive'), response );
                    }
                },
                error: function(error) {
                    console.error(error);
                }
            });
        }catch(error){
            console.error( __('Error fetching table data', 'awesome-motive') );
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
                <PanelBody title={ __('Hide Columns', 'awesome-motive') }>
                    {getHeaders().map((header) => (
                        <PanelRow key={header}>
                            <CheckboxControl
                                label={header}
                                checked={ getHiddenColumns().includes(header) }
                                onChange={ (hidden) => {
                                    if(hidden){
                                        setHiddenColumns([...getHiddenColumns(), header]);
                                    }else{
                                        setHiddenColumns(getHiddenColumns().filter((column) => column !== header));
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
                        !getHiddenColumns().includes(header) &&
                        <th>{header}</th>
                    ))}
                </tr>
                {Object.values(getTableBody()).map((row, rowIndex) => (
                    <tr key={rowIndex}>
                        {Object.values(row).map((column, columnIndex) => (
                            !getHiddenColumns().includes(getHeaders()[columnIndex]) &&
                            <td key={columnIndex}>{column}</td>
                        ))}
                    </tr>
                ))}
            </table>
        </div>
    );
}