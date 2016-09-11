--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.14
-- Dumped by pg_dump version 9.1.14
-- Started on 2015-01-19 12:34:27 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- TOC entry 1924 (class 0 OID 35482)
-- Dependencies: 162 1939
-- Data for Name: personal; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO personal VALUES (9, '12458745', 'WEFFWEFFEF', 'WEFEWFEWF', 'eewfewff@thehth.com', 'ESTADAL', '43554353534');


--
-- TOC entry 1938 (class 0 OID 35658)
-- Dependencies: 176 1924 1939
-- Data for Name: asistencia; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1943 (class 0 OID 0)
-- Dependencies: 175
-- Name: asistencia_idasis_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('asistencia_idasis_seq', 1, false);


--
-- TOC entry 1932 (class 0 OID 35540)
-- Dependencies: 170 1939
-- Data for Name: diasfestivo; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO diasfestivo VALUES (1, '2015-12-24 00:00:00', 'NOCHE BUENA');
INSERT INTO diasfestivo VALUES (3, '2015-05-01 00:00:00', 'PRIMERO DE MAYO');


--
-- TOC entry 1944 (class 0 OID 0)
-- Dependencies: 169
-- Name: diasfestivo_idfestivo_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('diasfestivo_idfestivo_seq', 3, true);


--
-- TOC entry 1926 (class 0 OID 35490)
-- Dependencies: 164 1939
-- Data for Name: horario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO horario VALUES (7, '07:00:00', '12:00:00', '13:00:00', '17:00:00', 'ADMINISTRATIVO', '0');


--
-- TOC entry 1945 (class 0 OID 0)
-- Dependencies: 163
-- Name: horario_idhor_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('horario_idhor_seq', 7, true);


--
-- TOC entry 1934 (class 0 OID 35551)
-- Dependencies: 172 1926 1924 1939
-- Data for Name: horario_persona; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO horario_persona VALUES (1, 9, 7);


--
-- TOC entry 1946 (class 0 OID 0)
-- Dependencies: 171
-- Name: horario_persona_idhorper_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('horario_persona_idhorper_seq', 1, true);


--
-- TOC entry 1928 (class 0 OID 35514)
-- Dependencies: 166 1939
-- Data for Name: permiso; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1947 (class 0 OID 0)
-- Dependencies: 165
-- Name: permiso_idper_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('permiso_idper_seq', 1, false);


--
-- TOC entry 1930 (class 0 OID 35522)
-- Dependencies: 168 1924 1939
-- Data for Name: permiso_persona; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- TOC entry 1948 (class 0 OID 0)
-- Dependencies: 167
-- Name: permiso_persona_idperper_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('permiso_persona_idperper_seq', 2, true);


--
-- TOC entry 1949 (class 0 OID 0)
-- Dependencies: 161
-- Name: personal_idper_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('personal_idper_seq', 9, true);


--
-- TOC entry 1936 (class 0 OID 35586)
-- Dependencies: 174 1939
-- Data for Name: usuario; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO usuario VALUES (1, 'JPEREZ', '$2a$08$uaJAHROoRVxbo3efxT9Uk.Ypw7SgQ88vgtRjB/X1Y8h.Ap4GWRjqi', 'ADMINISTRADOR', '2015-01-17 08:01:56', 'ACTIVO', '1234567', 'JUAN', 'PEREZ');


--
-- TOC entry 1950 (class 0 OID 0)
-- Dependencies: 173
-- Name: usuario_idusuario_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('usuario_idusuario_seq', 1, true);


-- Completed on 2015-01-19 12:34:28 VET

--
-- PostgreSQL database dump complete
--

