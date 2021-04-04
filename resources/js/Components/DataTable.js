import React, { useState, useEffect } from 'react';
import { Table, Input, Button, Select} from 'antd';
const { Search } = Input;
const { Option } = Select;
import styles from "./style.module.css";


const DataTable = ({rows, columns, selectValues, pageSize, pageGroupSize}) => {

  // Estado dos componentes
  const [ comp, setComp ] = useState({
    search: {
      value: ""
    },
    select : {
      defaultValue: selectValues
    },
    table: {
      dataShow: rows.length,
      dataSourceOriginal: rows,
      dataSource: rows,
      pagination: {
        pageSize
      },
      searchPaginationChildren: [],
    },
  }); 

  // Inicialização do array de quantidade para itens de pesquisa 
  useEffect(() => {
    // Define array de busca para items na página
    if(!Array.isArray(pageGroupSize) || (Array.isArray(pageGroupSize) && !pageGroupSize.length)) {
      pageGroupSize = [...[5,10,50,100], pageSize];
    } else {
      pageGroupSize = [...pageGroupSize, pageSize];
    }

    // Ordena valores no array
    pageGroupSize.sort(function(a, b){return a-b});

    const searchPaginationChildren = [];
    pageGroupSize.forEach((el, idx) => {
      searchPaginationChildren.push(<Option key={idx} value={el} >{el} por página</Option>);
    });

    let search = comp.search;
    let select = comp.select;
    let table  = { ...comp.table, searchPaginationChildren };
    
    setComp({search, select, table});

  }, []);

  // Monta opções de select
  const searchItemsChildren = [];
  Object.entries(columns).forEach(el => {
    if(el[1].key != 'action') {
      searchItemsChildren.push(<Option key={el[1].key}>{el[1].title}</Option>);
    }
  });

  // Limpa tags html nos termos de busca
  const cleanHTML = () => {
    return comp.table.dataSourceOriginal.map(el => {
      let verify = Object.entries(el);

      verify.forEach(e => {
        if(typeof e[1] === 'string') {
          el[e[0]] = el[e[0]].replace(/(<([^>]+)>)/gi, "");
        }
      });

      return el;
    });
  }

  // Table change
  const tableChange = (pagination, filters, sorter, extra) => {
    // API call no futuro
    // console.log(pagination, filters, sorter, extra);
  }
  
  // Filter columns change
  const filterChange = (defaultValue) => {
    let search = comp.search;
    let select = { ...comp.select, defaultValue };
    let table  = comp.table;
    
    setComp({search, select, table});
  }
  
  // Items per page change
  const itemsPageChange = (pageSize) => {
    let search      = comp.search;
    let select      = comp.select;
    let pagination  = { ...comp.table.pagination, pageSize };
    let table       = { ...comp.table, pagination };
    
    setComp({search, select, table});
  }
  
  // Search change
  const searchChange = (event) => {
    if(event.target.value.length >= 3) {
      searchClick(event.target.value);
    } else {
      const dataSource = cleanHTML();
      const dataShow   = dataSource.length;

      let search = comp.search
      let select = comp.select
      let table  = { ...comp.table, dataSource, dataShow }
  
      setComp({search, select, table});
    }
  }

  // Search click
  const searchClick = (searchText) => {
    let dataSource = [];
    
    if(searchText.trim().length == 0) {
      // Restaura dados iniciais
      dataSource = cleanHTML();

    } else {
      const fields = !!comp.select.defaultValue[0] ? comp.select.defaultValue : (!!comp.table.dataSourceOriginal[0] ? 
        Object.entries(comp.table.dataSourceOriginal[0]).map(el => el[0]) : []);

      // Função para marcar termo da pesquisa na string
      const boldString = (check, str, substr) => {
        
        const part1 = str.substring(0, check);
        const part2 = str.substring(check, substr.length+check);
        const part3 = str.substring(substr.length+check, str.length);

        if(check == 0) {
          return `<b><font color="red"><u>${part2}</u></font></b>${part3}`;
        } else if(check+substr.length < str.length) {
          return `${part1}<b><font color="red"><u>${part2}</u></font></b>${part3}`;
        } else {
          return `${part1}<b><font color="red"><u>${part2}</u></font></b>`;
        }
      }

      // Busca campos para pesquisa 
      dataSource = comp.table.dataSourceOriginal.filter(el => {
        let exists = false;
        
        fields.forEach(field => {

          // Limpa tags html
          el[field] = el[field].toString().replace(/(<([^>]+)>)/gi, "");

          // Compara termo de pesquisa com o campo
          const check = el[field].toString().normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase()
            .indexOf(searchText.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, "").toLowerCase().trim());
          
          // Válida busca
          if(!exists && check > -1) {
            exists = true;
          }

          // Adiciona negrito no termo pesquisado
          if(check > -1) {
            const str = el[field];
            const substr = searchText.trim();

            el[field] = boldString(check, str, substr);
          }
        });

        return exists;
      }); 
    }

    // Contabiliza resgitros com ou sem filtros
    const dataShow = dataSource.length;

    let search = comp.search
    let select = comp.select
    let table  = { ...comp.table, dataSource, dataShow }
    
    setComp({search, select, table});
  }

  return (
    <section >
      <header className={styles.header}>
        <Button type="primary" size="large" >{comp.table.dataShow} Registro(s)</Button>
        <Select
          mode="tags"
          size="large" 
          allowClear 
          placeholder="Refine sua busca para pesquisar nas colunas selecionadas"
          defaultValue={comp.select.defaultValue}
          onChange={filterChange}
          style={{ width: '55%' }}
        >
          {searchItemsChildren}
        </Select>
        <Select
          size="large" 
          defaultValue={comp.table.pagination.pageSize}
          onChange={itemsPageChange}
          style={{ width: '15%' }}
        >
          {comp.table.searchPaginationChildren}
        </Select>
        <Search
          placeholder="Digite seu texto aqui"
          allowClear
          enterButton="Buscar"
          size="large"
          onSearch={searchClick}
          onChange={searchChange}
          style={{width: '30%'}}
        />
      </header>
      <main>
        <Table 
          columns={columns} 
          dataSource={comp.table.dataSource} 
          pagination={comp.table.pagination}
          onChange={tableChange} 
        />
      </main>
    </section>
  );
}

export default DataTable;