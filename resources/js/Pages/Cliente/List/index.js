import React from 'react';
import { Table, Tag, Space } from 'antd';

const Cliente = ({rtn}) => {


  console.log(rtn);

  const columns = [
    {
      title: '# ID',
      dataIndex: 'id',
      key: 'id',
      render: text => <a>{text}</a>,
    },
    {
      title: 'Nome',
      dataIndex: 'nome',
      key: 'name',
    },
    {
      title: 'Email',
      dataIndex: 'email',
      key: 'email',
    },
    {
      title: 'Tipo',
      dataIndex: 'tipo',
      key: 'tipo',
    },
    {
      title: 'Ações',
      key: 'action',
      render: (text, record) => (
        <Space size="middle">
          <a>Invite {record.name}</a>
          <a>Delete</a>
        </Space>
      ),
    },
  ];

  return (
    <Table 
      columns={columns} 
      dataSource={rtn.data.rows} 
      pagination={{ pageSize: 5 }}
    />
  );
}

export default Cliente;