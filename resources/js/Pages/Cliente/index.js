import React, { useState, useEffect } from 'react';
import { Table } from 'reactstrap';
// import { Pagination } from 'react-laravel-paginex';
import Pagination from "react-js-pagination"; 
import { Inertia } from '@inertiajs/inertia'; 

const Cliente = ({rtn}) => {

  const [meta, setMeta] = useState(rtn.meta);
  const [data, setData] = useState();

  useEffect(() => {
    getData(1);
  }, []);

  // Monta dados da tabela
  const mountData = (data) => {
    return data.map((el,idx) => {
      return (
        <tr key={`cliente-${idx}`}>
          <th scope="row">{el.id}</th>
          <td>{el.nome}</td>
          <td>{el.email}</td>
          <td>{el.tipo}</td>
        </tr>
      )
    })
  }

  // Busca dados da API
  const getData = (page) => {
    Inertia.get('/cliente?page=' + page, { headers: 'Authorization:Bearer 6|yM5QkC0nS547uT9GBM4qFsLGooZpzeEN6L8c5uS1' }, {
        preserveState: true,
        onSuccess: (comp) => {
          setMeta(comp.props.rtn.meta)
          setData(mountData(comp.props.rtn.data));
        },
        onError: (errors) => {
          console.log("onError", errors)
        },
      }
    );
  }

  return (
    <>
      <Table id="cliente-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Email</th>
            <th>Tipo</th>
          </tr>
        </thead>
        <tbody> 
            { data }
        </tbody>
      </Table>

      <Pagination
        itemClass={"page-item"}
        linkClass={"page-link"}
        activePage={meta.current_page}
        itemsCountPerPage={meta.per_page}
        totalItemsCount={meta.total}
        onChange={getData}
      />

    </>
  );
}

export default Cliente;