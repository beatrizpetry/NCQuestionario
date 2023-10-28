CREATE TABLE Questionário (
	Pergunta VARCHAR(200),
    Situação VARCHAR(15) NOT NULL,
    Descrição_nc VARCHAR(300),
    Responsável_nc VARCHAR(60),
    Classificação_nc VARCHAR(30),
    Resolvido_nc VARCHAR(20)
);

INSERT INTO Questionário (Pergunta) VALUES
    ('1. O projeto possui uma política de medição de processos documentado?'),
    ('2. Foram definidos e documentados os objetivos específicos da medição dentro do projeto?'),
    ('3. Os objetivos da medição estão alinhados com as metas do projeto?'),
    ('4. Os objetivos da medição foram comunicados para todas as partes envolvidas?'),
    ('5. Foram identificados os indicadores de desempenho de relevância para a avaliação do progresso do projeto?'),
    ('6. Os indicadores de desempenho são definidos, documentados, atualizados e corretamente armazenados?'),
    ('7. Foi estabelecido o processo de coleta dos dados para ser registrado os indicadores de desempenho?'),
    ('8. Os dados de desempenho que são coletados são armazenados de forma em que toda a equipe consiga acessá-los de forma segura e fácil?'),
    ('9. A frequência em que deve haver a coleta de dados de desempenho dentro do projeto foi definida e documentada?'),
    ('10. É realizado análises regularmente dos dados de desempenho coletados?'),
    ('11. Existem ações corretivas/preventivas determinadas quando há problemas encontrados nas análises dos dados coletados?'),
    ('12. É comunicado regularmente para a equipe e/ou partes interessadas os resultados das coletas/análises de dados?'),
    ('13. São criados relatórios completos de desempenho (com gráficos, comparações e análise de tendência) para ajudar a equipe a melhorar as tomadas de decisão dentro do projeto?'),
    ('14. Os relatórios de desempenho são compartilhados com os membros da equipe do projeto regularmente?'),
    ('15. Os relatórios são utilizados para orientar a equipe e garantir uma melhora contínua dentro da empresa?'),
    ('16. As ações de melhoria resultantes das medições são rastreadas e monitoradas para garantir sua eficácia?'),
    ('17. São estabelecidas metas específicas de desempenho para cada indicador de medição?'),
    ('18. As medições abrangem todas as fases do ciclo de vida do projeto, incluindo planejamento, desenvolvimento, testes e implantação?'),
    ('19. São revisadas periodicamente as métricas e indicadores de desempenho para garantir que ainda sejam relevantes para o projeto?'),
    ('20. As métricas e indicadores de desempenho são ajustados quando necessário para refletir mudanças no projeto ou nas metas do projeto?'),
    ('21. As ações de melhoria no projeto são priorizadas com base nas informações de medição?'),
    ('22. São feitas avaliações externas, como revisões por pares ou auditorias independentes, para verificar a precisão das medições?');

ALTER TABLE Questionário
ADD Data_inicio DATE NULL,
ADD Data_fim DATE NULL;