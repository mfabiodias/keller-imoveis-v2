import React from 'react';
import { InertiaLink } from '@inertiajs/inertia-react';
import { DataTable } from "../../../Components";
import parse from 'html-react-parser';

const Client = ({rtn}) => { 

    const columns = [
        {
            title: 'ID',
            dataIndex: 'id',
            key: 'id',
            render: text => <a>{text}</a>,
            sorter: (a, b) => a.id - b.id,
            sortDirections: ['descend', 'ascend'],
        },
        {
            title: 'Nome',
            dataIndex: 'nome',
            key: 'nome',
            render: text => parse(text),
            sorter: (a, b) => a.nome.length - b.nome.length,
            sortDirections: ['descend', 'ascend'],
        },
        {
            title: 'Email',
            dataIndex: 'email',
            key: 'email',
            render: text => parse(text),
            sorter: (a, b) => a.email.length - b.email.length,
            sortDirections: ['descend', 'ascend'],
        },
        {
            title: 'Tipo',
            dataIndex: 'tipo',
            key: 'tipo',
            render: text => parse(text),
            sorter: (a, b) => a.tipo.length - b.tipo.length,
            sortDirections: ['descend', 'ascend'],
        },
        {
            title: 'Ações',
            key: 'action',
            render: (text, record) => (
                <>
                    <InertiaLink href={route('cliente.show', { cliente: record.id })} as="button">
                        Show
                    </InertiaLink>
                    <InertiaLink href={route('cliente.edit', { cliente: record.id })} as="button">
                        Editar
                    </InertiaLink>
                    <InertiaLink href={route('cliente.destroy', { cliente: record.id })} as="button" method="delete">
                        Excluir
                    </InertiaLink>
                </>
            ),
        },
    ];

    return ( 
        <DataTable 
            rows={rtn.data.rows}
            columns={columns}
            selectValues={['nome','tipo','email']} 
            pageSize={5}
            pageGroupSize={[10,25,50,100]}
        />
    );
};

export default Client;