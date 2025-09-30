import React, { useState, useEffect } from "react";
import { Button } from "react-bootstrap";
import { ChartBarIcon } from "@heroicons/react/24/solid";
import { GiWeight } from "react-icons/gi";
import { CiInboxIn } from "react-icons/ci";
import { MdOutlineCleaningServices } from "react-icons/md";
import { FaHelmetSafety } from "react-icons/fa6";
import { CiBarcode } from "react-icons/ci";

import DataTable from "datatables.net-react";
import DT from "datatables.net-dt";
import "datatables.net-dt/css/dataTables.dataTables.min.css";
DataTable.use(DT);

import JSZip from "jszip";
window.JSZip = JSZip;

import "datatables.net-buttons/js/dataTables.buttons.min.js";
import "datatables.net-buttons/js/buttons.html5.min.js";
import "datatables.net-buttons/js/buttons.print.min.js";
import "datatables.net-buttons/js/buttons.colVis.min.js";
import "datatables.net-buttons-dt/css/buttons.dataTables.min.css";

import axios from "axios";

import moment from "moment";

import PausasAcondicionamiento from "../../components/ui/modals/PausasAcondicionamientoModal";
import PesajeAcondicionamiento from "../../components/ui/modals/PesajeAcondicionamientoModal";
import IngresosAcondicionamiento from "../../components/ui/modals/IngresosAcondicionamientoModal";
import AseoAcondicionamiento from "../../components/ui/modals/AseoAcondicionamientoModal";
import OperarioAcondicionamiento from "../../components/ui/modals/OperarioAcondicionamientoModal";
import CodigoAcondicionamiento from "../../components/ui/modals/CodigoAcondicionamientoModal";

const historialAcondicionamiento = () => {
  const [tableData, setTableData] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [showModalPesaje, setShowModalPesaje] = useState(false);
  const [showModalIngresos, setShowModalIngresos] = useState(false);
  const [showModalAseos, setShowModalAseos] = useState(false);
  const [showModalOperarios, setShowModalOperarios] = useState(false);
  const [showModalCodigo, setShowModalCodigo] = useState(false);
  const [selectedRowData, setSelectedRowData] = useState(null);

  const [isMobile, setIsMobile] = useState(window.innerWidth <= 768);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth <= 768);
    };
    window.addEventListener("resize", handleResize);

    handleResize();
    return () => {
      window.removeEventListener("resize", handleResize);
    };
  }, []);

  useEffect(() => {
    const datos = async () => {
      const response = await axios.get("/api/historialAcondicionamiento/");

      if (response.status == 200) {
        setTableData(response.data);
      }
    };
    datos();
  }, []);

  const formatTime = (seconds) => {
    const hrs = Math.floor(seconds / 3600)
      .toString()
      .padStart(2, "0");
    const mins = Math.floor((seconds % 3600) / 60)
      .toString()
      .padStart(2, "0");
    const secs = (seconds % 60).toString().padStart(2, "0");
    return `${hrs}:${mins}:${secs}`;
  };

  const handleOpenModal = (row) => {
    setSelectedRowData(row);
    setShowModal(true);
  };

  const handleOpenModalPesaje = (row) => {
    setSelectedRowData(row);
    setShowModalPesaje(true);
  };

  const handleOpenModalIngresos = (row) => {
    setSelectedRowData(row);
    setShowModalIngresos(true);
  };

  const handleOpenModalAseos = (row) => {
    setSelectedRowData(row);
    setShowModalAseos(true);
  };

  const handleOpenModalOperarios = (row) => {
    setSelectedRowData(row);
    setShowModalOperarios(true);
  };

  const handleOpenModalCodigo = (row) => {
    setSelectedRowData(row);
    setShowModalCodigo(true);
  };

  const handleCloseModal = () => {
    setShowModal(false);
    setShowModalPesaje(false);
    setShowModalIngresos(false);
    setShowModalAseos(false);
    setShowModalOperarios(false);
    setShowModalCodigo(false);
  };

  const columns = [
    {
      data: "id_acondicionamiento_tablet",
      title: "id",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "nombre_agricultor",
      title: "multiplicador",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "nombre_cliente",
      title: "cliente",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "lote",
      title: "lote",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "nombre_especie",
      title: "especie",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      // esto debe coincidir con el arra
      data: "nombre_maquina",
      title: "maquina",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "fecha_inicio",
      title: "inicio",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
      // validar
      render: function (data) {
        // Formatea la fecha con moment
        return moment(data).isValid()
          ? moment(data).format("DD-MM-YYYY HH:mm:ss")
          : "Fecha inválida";
      },
    },
    {
      data: "fecha_termino",
      title: "termino",
      render: function (data) {
        // Formatea la fecha con moment
        return moment(data).isValid()
          ? moment(data).format("DD-MM-YYYY HH:mm:ss")
          : "Fecha inválida";
      },
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "dias",
      title: "dias",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "tiempo",
      title: "tiempo total",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "tiempo_pausa",
      title: "tiempo pausa",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
      render: (data) => {
        return data == 0 ? "-" : formatTime(data);
      },
    },
    {
      data: "tiempo_total",
      title: "tiempo acondicionamiento",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
      render: (data) => {
        return data == 0 ? "-" : formatTime(data);
      },
    },
    {
      data: "kilos_iniciales",
      title: "kilos iniciales",
      render: (data) => {
        return data
          ? parseFloat(data).toLocaleString("es-ES", {
              minimumFractionDigits: 3,
              maximumFractionDigits: 3,
            })
          : "0,000";
      },
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "kilos_operario",
      title: "kilos operario",
      render: (data) => {
        return data
          ? parseFloat(data).toLocaleString("es-ES", {
              minimumFractionDigits: 3,
              maximumFractionDigits: 3,
            })
          : "0,000";
      },
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "kilos_finales",
      title: "kilos finales",
      render: (data) => {
        return data
          ? parseFloat(data).toLocaleString("es-ES", {
              minimumFractionDigits: 3,
              maximumFractionDigits: 3,
            })
          : "0,000";
      },
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "clean_out",
      title: "Clean out",
      render: (data) => {
        const number = parseFloat(data) / 100;
        return !isNaN(number)
          ? number.toLocaleString("es-ES", {
              style: "percent",
              minimumFractionDigits: 2,
              maximumFractionDigits: 2,
            })
          : "0,00%";
      },
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "nombre_envase",
      title: "tipo envase",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "n_envases",
      title: "cantidad de envase",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "ubicacion",
      title: "ubicacion",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "observaciones_seca",
      title: "Observaciones",
      render: (data) => {
        return data ? data.toUpperCase() : "SIN COMENTARIOS";
      },
    },
    {
      data: "observacion_termino",
      title: "Observacion termino acondicionamiento",
      render: (data) => {
        return data ? data.toUpperCase() : "SIN COMENTARIOS";
      },
    },
    {
      data: "color_lechuga",
      title: "Color",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "nombre_encargado",
      title: "Encargado",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: "supervisor",
      title: "Supervisor",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: null,
      title: "Pausas",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: null,
      title: "Pesajes",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: null,
      title: "Ingresos",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: null,
      title: "Aseo",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: null,
      title: "Operarios",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
    {
      data: null,
      title: "Codigo",
      createdCell: (td) => {
        td.style.textAlign = "center";
      },
    },
  ];  

  // botones
  const slots = {
    24: (data, row) => {
      return (
        <Button
          variant="success"
          size="sm"
          onClick={() => handleOpenModal(row)}
          disabled={row.tiempo_pausa == 0 ? true : false}
        >
          <ChartBarIcon style={{ width: "1rem", height: "1rem" }} />
        </Button>
      );
    },
    25: (data, row) => {
      return (
        <Button
          variant="success"
          size="sm"
          onClick={() => handleOpenModalPesaje(row)}
        >
          <GiWeight style={{ width: "1rem", height: "1rem" }} />
        </Button>
      );
    },
    26: (data, row) => {
      return (
        <Button
          variant="success"
          size="sm"
          onClick={() => handleOpenModalIngresos(row)}
          disabled={row.registros_ingresos == 0 ? true : false}
        >
          <CiInboxIn style={{ width: "1rem", height: "1rem" }} />
        </Button>
      );
    },
    27: (data, row) => {
      return (
        <Button
          variant="success"
          size="sm"
          onClick={() => handleOpenModalAseos(row)}
        >
          <MdOutlineCleaningServices style={{ width: "1rem", height: "1rem" }} />
        </Button>
      );
    },
    28: (data, row) => {
      return (
        <Button
          variant="success"
          size="sm"
          onClick={() => handleOpenModalOperarios(row)}
        >
          <FaHelmetSafety style={{ width: "1rem", height: "1rem" }} />
        </Button>
      );
    },
    29: (data, row) => {
      return (
        <Button
          variant="success"
          size="sm"
          onClick={() => handleOpenModalCodigo(row)}
        >
          <CiBarcode style={{ width: "1rem", height: "1rem" }} />
        </Button>
      );
    },
  };

  const desktopDom =
    "<'row'<'col-md-4 text-start'l><'col-md-4 text-center'f><'col-md-4 text-end'B>>" +
    "<'row'<'col-sm-12'tr>>" +
    "<'row'<'col-sm-6'i><'col-sm-6 text-end'p>>";

  const mobileDom =
    "<'row'<'col-12 text-center'l><'col-12 text-center'f><'col-12 text-end'B>>" +
    "<'row'<'col-12'tr>>" +
    "<'row'<'col-12 text-center'i><'col-12 text-center'p>>";

  const options = {
    order: [[0, "desc"]],
    scrollX: !isMobile,
    responsive: isMobile,

    dom: isMobile ? mobileDom : desktopDom,

    buttons: [
      {
        extend: "excelHtml5",
        text: "Exportar a Excel",
        exportOptions: {
          columns: [
            0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
            19, 20, 21, 22,
          ],
          format: {
            body: function (data, row, col, node) {
              if (col === 12 || col === 13 || col === 14) {
                // Verifica si es la columna 11 o 12
                const val = parseFloat(
                  data != null ? data.toString().replace(",", ".") : ""
                );
                if (!isNaN(val)) {
                  return val;
                }
              }
              return data;
            },
          },
        },
        customize: function (xlsx) {
          const sheet = xlsx.xl.worksheets["sheet1.xml"];
          const cells = sheet.getElementsByTagName("c");
          for (let i = 0; i < cells.length; i++) {
            cells[i].setAttribute("s", "51");
          }
          const colM = "M";
          for (let i = 0; i < cells.length; i++) {
            const cell = cells[i];
            const cellRef = cell.getAttribute("M5");
            if (cellRef && cellRef.startsWith(colM)) {
              cell.setAttribute("s", "63");
            }
          }
          const colN = "N";
          for (let i = 0; i < cells.length; i++) {
            const cell = cells[i];
            const cellRef = cell.getAttribute("N2");
            if (cellRef && cellRef.startsWith(colN)) {
              cell.setAttribute("s", "63");
            }
          }
          const colo = "O";
          for (let i = 0; i < cells.length; i++) {
            const cell = cells[i];
            const cellRef = cell.getAttribute("O2");
            if (cellRef && cellRef.startsWith(colo)) {
              cell.setAttribute("s", "63");
            }
          }
        },
      },
      {
        extend: "csvHtml5",
        text: "Exportar a CSV",
        exportOptions: {
          columns: [
            0, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18,
          ],
          format: {
            body: function (data, row, col, node) {
              if (col === 12) {
                const strVal = data != null ? data.toString() : "";
                const val = parseFloat(strVal);
                if (!isNaN(val)) {
                  return val.toFixed(3).replace(".", ",");
                }
              }
              return data;
            },
          },
        },
      },
    ],

    language: {
      decimal: "",
      emptyTable: "No hay información",
      info: "Mostrando desde _START_ a _END_ de _TOTAL_ registros",
      infoEmpty: "Mostrando desde 0 a 0 de 0 registros",
      infoFiltered: "(Filtrado de _MAX_ total entradas)",
      lengthMenu: "Mostrar _MENU_ registros",
      loadingRecords: '<p class="fs-4 fw-bold">Cargando información...</p>',
      processing: '<p class="fs-4 fw-bold">Cargando información...</p>',
      search: "",
      searchPlaceholder: "Buscar en los registros",
      zeroRecords: "Sin resultados encontrados",
      paginate: {
        next: "Siguiente",
        previous: "Anterior",
      },
    },
    columnDefs: [
      {
        targets: "_all",
        className: "text-nowrap",
      },
      {
        targets: 1,
        className: "text-center",
      },
    ],
  };

  return (
    <>
      <div className="d-flex justify-content-center ">
        <div className=" px-5 pt-3 rounded-top-only text-center bg-white d-inline-flex justify-content-center">
          <h4>Historial Acondicionamiento</h4>
        </div>
      </div>
      <div className="bg-white px-2 py-1 shadow rounded">
        <DataTable
          className="display order-column stripe cell-border table-fixed compact"
          slots={slots}
          data={tableData}
          columns={columns}
          options={options}
        />
      </div>

      {showModal && (
        <PausasAcondicionamiento
          show={showModal}
          onHide={handleCloseModal}
          rowData={selectedRowData}
        />
      )}

      {showModalPesaje && (
        <PesajeAcondicionamiento
          show={showModalPesaje}
          onHide={handleCloseModal}
          rowData={selectedRowData}
        />
      )}

      {showModalIngresos && (
        <IngresosAcondicionamiento
          show={showModalIngresos}
          onHide={handleCloseModal}
          rowData={selectedRowData}
        />
      )}

      {showModalAseos && (
        <AseoAcondicionamiento
          show={showModalAseos}
          onHide={handleCloseModal}
          rowData={selectedRowData}
        />
      )}

      {showModalOperarios && (
        <OperarioAcondicionamiento
          show={showModalOperarios}
          onHide={handleCloseModal}
          rowData={selectedRowData}
        />
      )}

      {showModalCodigo && (
        <CodigoAcondicionamiento
          show={showModalCodigo}
          onHide={handleCloseModal}
          rowData={selectedRowData}
        />
      )}
    </>
  );
};

export default historialAcondicionamiento;
