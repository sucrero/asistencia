--
-- PostgreSQL database dump
--

-- Dumped from database version 9.1.14
-- Dumped by pg_dump version 9.1.14
-- Started on 2015-01-31 19:25:02 VET

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

SET search_path = public, pg_catalog;

--
-- TOC entry 1891 (class 0 OID 35482)
-- Dependencies: 162 1892
-- Data for Name: personal; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO personal VALUES (19, '15742854', 'LUISA', 'JIMENEZ', 'ljimenez@hotmail.com', 'NACIONAL', '04124561256', 'ADMINISTRATIVO', 'TITULAR');
INSERT INTO personal VALUES (20, '18456789', 'RAMON', 'PEREZ', 'rperez@gmail.com', 'ESTADAL', '04164587892', 'OBRERO', 'COLABORADOR');
INSERT INTO personal VALUES (21, '12345678', 'JUAN', 'SOTILLO', 'jsotillo@hotmail.com', 'ESTADAL', '04124567897', 'ADMINISTRATIVO', 'COLABORADOR');
INSERT INTO personal VALUES (22, '15742456', 'CARLOS', 'RAMOS', 'cramos@hotmail.com', 'ALCALDIA', '04124567965', 'OBRERO', 'COLABORADOR');
INSERT INTO personal VALUES (24, '12345687', 'ANGELICA', 'LUIS', 'aluis@hotmail.com', 'ALCALDIA', '04124567896', 'ADMINISTRATIVO', 'INTERINO');
INSERT INTO personal VALUES (25, '11542589', 'CECILIO', 'GOMEZ', 'cgomez@hotmail.com', 'NACIONAL', '04144587896', 'ADMINISTRATIVO', 'SUPLENTE');
INSERT INTO personal VALUES (26, '10254145', 'MARIA', 'FERNENDEZ', 'mfernandez@hotmail.com', 'ALCALDIA', '04125634578', 'MADRE PROCESADORA', 'INTERINO');
INSERT INTO personal VALUES (27, '453545', 'GRGR', 'RGREGR', 'regregr@thtth.com', 'ESTADAL', '45544354354', 'ADMINISTRATIVO', 'INTERINO');


--
-- TOC entry 1896 (class 0 OID 0)
-- Dependencies: 161
-- Name: personal_idper_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('personal_idper_seq', 27, true);


-- Completed on 2015-01-31 19:25:02 VET

--
-- PostgreSQL database dump complete
--

